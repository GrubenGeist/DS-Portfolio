<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue';
import * as THREE from 'three';
import { FontLoader } from 'three/examples/jsm/loaders/FontLoader.js';
import { TextGeometry } from 'three/examples/jsm/geometries/TextGeometry.js';
import { Info, X } from 'lucide-vue-next';

// =============================================================================
// PROPS & KONFIGURATION
// =============================================================================
interface Hero3DProps {
  words: string[];

  // --- Container-Dimensionen ---
  containerHeight?: string;

  // --- Wolken-Dimensionen ---
  cloudWidth?: number;
  cloudHeight?: number;
  cloudDepth?: number;
  wordCount?: number;
  wordSpacing?: number;

  // --- Schrift-Einstellungen ---
  fontUrl?: string;
  fontSize?: number;
  fontDepth?: number;

  // --- Animations-Einstellungen ---
  autoRotateSpeed?: number;
  cameraHoverEffect?: boolean;

  // --- Plattform-spezifische Einstellungen ---
  faceCameraOnMobile?: boolean;
  faceCameraOnDesktop?: boolean;

  // --- Interaktions-Effekte ---
  enableForegroundFade?: boolean;
  foregroundFadeDepth?: number;
}

const props = withDefaults(defineProps<Hero3DProps>(), {
  containerHeight: '100vh',
  cloudWidth: 50,
  cloudHeight: 35,
  cloudDepth: 50,
  wordCount: 70,
  wordSpacing: 1.2,
  fontUrl: '/fonts/helvetiker_regular.typeface.json',
  fontSize: 1.0,
  fontDepth: 0.04,
  autoRotateSpeed: 0.0005,
  cameraHoverEffect: true,
  faceCameraOnMobile: true,
  faceCameraOnDesktop: true,
  enableForegroundFade: true,
  foregroundFadeDepth: 18,
});

const containerRef = ref<HTMLElement | null>(null);

// Globale Variablen für die Szene
let animationId: number | null = null;
let running = false;
let renderer: THREE.WebGLRenderer | null = null;
let scene: THREE.Scene;
let camera: THREE.PerspectiveCamera;
let wordMeshes: THREE.Mesh[] = [];
let cloudGroup: THREE.Group;
let textMaterial: THREE.MeshBasicMaterial; // Basis-Material
const lightModeColor = new THREE.Color(0x1e293b);
const darkModeColor = new THREE.Color(0xffffff);

// Listener-Variablen
let mouseMoveListener: ((event: MouseEvent) => void) | null = null;
let touchMoveListener: ((event: TouchEvent) => void) | null = null;
let touchEndListener: (() => void) | null = null;
let resizeListener: (() => void) | null = null;
let visibilityListener: (() => void) | null = null;
let io: IntersectionObserver | null = null;
let themeObserver: MutationObserver | null = null;

// Zustände für Interaktionen
const isMouseOver = ref(false);
const isDragging = ref(false);
const previousMousePosition = { x: 0, y: 0 };
const isMobile = ref(false);
const showInfoBox = ref(false);

// Globale Variablen für die Mausposition
let mouseX = typeof window !== 'undefined' ? window.innerWidth / 2 : 0;
let mouseY = typeof window !== 'undefined' ? window.innerHeight / 2 : 0;

// Performance-Helfer
const geometryCache = new Map<string, THREE.BufferGeometry>(); // pro Wort eine Geometrie
const _worldPos = new THREE.Vector3();                          // temp Vektor wiederverwenden
let frameCount = 0;                                             // für LookAt-Throttle
const LOOKAT_EVERY = 3;

// ==== Mini-Optimierungen ====
// Mobile Word Cap (nur für Erzeugung; Props bleiben unverändert)
const MOBILE_WORD_CAP = 30;

// Reduced Motion: effektive Auto-Rotate-Speed
let autoRotateSpeedEffective = props.autoRotateSpeed;
let prefersReducedMql: MediaQueryList | null = null;
let reducedMotionListener: ((e: MediaQueryListEvent) => void) | null = null;

function updateAutoRotate(reduced: boolean) {
  autoRotateSpeedEffective = reduced ? 0 : props.autoRotateSpeed;
}
function setupReducedMotion() {
  if (typeof window === 'undefined' || !('matchMedia' in window)) {
    updateAutoRotate(false);
    return;
  }
  prefersReducedMql = window.matchMedia('(prefers-reduced-motion: reduce)');
  updateAutoRotate(prefersReducedMql.matches);

  reducedMotionListener = (e: MediaQueryListEvent) => updateAutoRotate(e.matches);
  // cross-browser: addEventListener / addListener
  if ('addEventListener' in prefersReducedMql) {
    prefersReducedMql.addEventListener('change', reducedMotionListener);
  } else {
    // @ts-ignore older Safari
    prefersReducedMql.addListener(reducedMotionListener);
  }
}

// =============================================================================
// HILFSFUNKTIONEN
// =============================================================================
function getTextGeometry(word: string, font: any) {
  let geo = geometryCache.get(word);
  if (!geo) {
    const g = new TextGeometry(word, { font, size: props.fontSize, depth: props.fontDepth });
    g.center();
    geometryCache.set(word, g);
    geo = g;
  }
  return geo;
}

function setAllTextColor(color: THREE.Color | number) {
  const col = color instanceof THREE.Color ? color : new THREE.Color(color);
  wordMeshes.forEach(m => (m.material as THREE.MeshBasicMaterial).color.set(col));
}

function startLoop() {
  if (!running) {
    running = true;
    animationId = requestAnimationFrame(animate);
  }
}

function stopLoop() {
  if (running) {
    running = false;
    if (animationId != null) cancelAnimationFrame(animationId);
    animationId = null;
  }
}

// =============================================================================
// INITIALISIERUNG
// =============================================================================
const initScene = () => {
  if (!containerRef.value) return;
  const container = containerRef.value;

  scene = new THREE.Scene();
  camera = new THREE.PerspectiveCamera(70, container.clientWidth / container.clientHeight, 0.1, 1000);
  camera.position.z = 25;

  renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true, powerPreference: 'high-performance' });
  // DPR Cap (mobil niedriger)
  const dprCap = isMobile.value ? 1.3 : 1.8;
  renderer.setPixelRatio(Math.min(window.devicePixelRatio, dprCap));
  renderer.setSize(container.clientWidth, container.clientHeight);
  renderer.setClearColor(0x000000, 0);
  container.appendChild(renderer.domElement);

  const fontLoader = new FontLoader();
  fontLoader.load(props.fontUrl, (font) => {
    const isDark = document.documentElement.classList.contains('dark');
    const initialColor = isDark ? darkModeColor : lightModeColor;

    // Transparenz nur aktivieren, wenn Fading benötigt wird
    textMaterial = new THREE.MeshBasicMaterial({
      color: initialColor,
      transparent: props.enableForegroundFade,
      depthWrite: props.enableForegroundFade ? false : true,
    });

    cloudGroup = new THREE.Group();
    wordMeshes = [];

    // >>> Mobile Word Cap beachten <<<
    const count = isMobile.value ? Math.min(props.wordCount, MOBILE_WORD_CAP) : props.wordCount;

    for (let i = 0; i < count; i++) {
      const randomWord = props.words[Math.floor(Math.random() * props.words.length)];
      const textGeometry = getTextGeometry(randomWord, font);

      // Wenn per-Mesh-Opacity gebraucht wird -> eigenes Material, sonst shared
      const material = props.enableForegroundFade ? textMaterial.clone() : textMaterial;

      const textMesh = new THREE.Mesh(textGeometry, material);

      // Startposition
      textMesh.userData.initialPosition = new THREE.Vector3(
        (Math.random() - 0.5) * props.cloudWidth * props.wordSpacing,
        (Math.random() - 0.5) * props.cloudHeight * props.wordSpacing,
        (Math.random() - 0.5) * props.cloudDepth * props.wordSpacing
      );
      textMesh.position.copy(textMesh.userData.initialPosition);

      cloudGroup.add(textMesh);
      wordMeshes.push(textMesh);
    }
    scene.add(cloudGroup);

    // Theme-Wechsel effizient beobachten (statt pro Frame in animate)
    themeObserver = new MutationObserver(() => {
      const dark = document.documentElement.classList.contains('dark');
      const targetColor = dark ? darkModeColor : lightModeColor;
      setAllTextColor(targetColor);
    });
    themeObserver.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });

    // Start der Animationsschleife (sichtbarkeitsgesteuert unten)
    startLoop();
  });

  setupEventListeners();

  // Sichtbarkeit: nur rendern, wenn sichtbar
  if (containerRef.value) {
    io = new IntersectionObserver(([e]) => (e.isIntersecting ? startLoop() : stopLoop()), {
      root: null,
      threshold: 0.01,
    });
    io.observe(containerRef.value);
  }
  visibilityListener = () => (document.hidden ? stopLoop() : startLoop());
  document.addEventListener('visibilitychange', visibilityListener);
};

// =============================================================================
// EVENT-LISTENER & INTERAKTIONEN
// =============================================================================
const setupEventListeners = () => {
  if (!containerRef.value || !renderer) return;
  const container = containerRef.value;
  renderer.domElement.style.cursor = 'grab';

  // Hover-Status
  container.addEventListener('mouseenter', () => { isMouseOver.value = true; });
  container.addEventListener('mouseleave', () => { isMouseOver.value = false; });

  // Drag Start
  container.addEventListener('mousedown', (e) => {
    isDragging.value = true;
    renderer!.domElement.style.cursor = 'grabbing';
    previousMousePosition.x = e.clientX;
    previousMousePosition.y = e.clientY;
  });

  container.addEventListener('touchstart', (e) => {
    if (e.touches.length === 1) {
      isDragging.value = true;
      previousMousePosition.x = e.touches[0].clientX;
      previousMousePosition.y = e.touches[0].clientY;
    }
  }, { passive: true });

  // Drag End
  window.addEventListener('mouseup', () => {
    if (isDragging.value) {
      isDragging.value = false;
      if (renderer) renderer.domElement.style.cursor = 'grab';
    }
  });

  touchEndListener = () => { if (isDragging.value) isDragging.value = false; };
  window.addEventListener('touchend', touchEndListener);

  const handleDrag = (clientX: number, clientY: number) => {
    if (isDragging.value && cloudGroup) {
      const deltaX = clientX - previousMousePosition.x;
      const deltaY = clientY - previousMousePosition.y;
      cloudGroup.rotation.y += deltaX * 0.005;
      cloudGroup.rotation.x += deltaY * 0.005;
      previousMousePosition.x = clientX;
      previousMousePosition.y = clientY;
    }
  };

  mouseMoveListener = (event: MouseEvent) => {
    mouseX = event.clientX;
    mouseY = event.clientY;
    handleDrag(event.clientX, event.clientY);
  };
  window.addEventListener('mousemove', mouseMoveListener);

  touchMoveListener = (event: TouchEvent) => {
    if (event.touches.length === 1) handleDrag(event.touches[0].clientX, event.touches[0].clientY);
  };
  window.addEventListener('touchmove', touchMoveListener, { passive: true });

  // Debounced Resize
  let resizeRaf = 0;
  resizeListener = () => {
    if (resizeRaf) cancelAnimationFrame(resizeRaf);
    resizeRaf = requestAnimationFrame(() => {
      if (containerRef.value && renderer && camera) {
        renderer.setSize(containerRef.value.clientWidth, containerRef.value.clientHeight);
        camera.aspect = containerRef.value.clientWidth / containerRef.value.clientHeight;
        camera.updateProjectionMatrix();
      }
    });
  };
  window.addEventListener('resize', resizeListener);
};

// =============================================================================
// ANIMATIONS-SCHLEIFE
// =============================================================================
const animate = (time: number) => {
  if (!running) return;

  // Auto-Rotation nur wenn nicht gedragt (und reduced-motion beachtet)
  if (cloudGroup && !isDragging.value) {
    cloudGroup.rotation.y += autoRotateSpeedEffective;
  }

  // Kamera-Hover-Effekt
  if (camera && props.cameraHoverEffect && !isDragging.value) {
    if (isMouseOver.value) {
      camera.position.x += ((mouseX - window.innerWidth / 2) / 400 - camera.position.x) * 0.05;
      camera.position.y += (-(mouseY - window.innerHeight / 2) / 400 - camera.position.y) * 0.05;
    } else {
      camera.position.x += (0 - camera.position.x) * 0.05;
      camera.position.y += (0 - camera.position.y) * 0.05;
    }
  }

  // Wörter: Blickrichtung & Foreground-Fade
  if (wordMeshes.length > 0) {
    const faceCam = (isMobile.value && props.faceCameraOnMobile) || (!isMobile.value && props.faceCameraOnDesktop);
    const doLookAt = faceCam && (frameCount++ % LOOKAT_EVERY === 0);

    for (let i = 0; i < wordMeshes.length; i++) {
      const mesh = wordMeshes[i];
      if (doLookAt) mesh.lookAt(camera.position);

      if (props.enableForegroundFade) {
        mesh.getWorldPosition(_worldPos);
        const z = _worldPos.z;
        if (z > props.foregroundFadeDepth) {
          const opacity = 1.0 - (z - props.foregroundFadeDepth) / (camera.position.z - props.foregroundFadeDepth);
          (mesh.material as THREE.MeshBasicMaterial).opacity = Math.max(0, Math.min(1, opacity));
        } else {
          (mesh.material as THREE.MeshBasicMaterial).opacity = 1.0;
        }
      }
    }
  }

  if (scene && camera && renderer) {
    camera.lookAt(scene.position);
    renderer.render(scene, camera);
  }

  animationId = requestAnimationFrame(animate);
};

// =============================================================================
// LIFECYCLE HOOKS
// =============================================================================
onMounted(() => {
  isMobile.value = window.innerWidth < 768;
  setupReducedMotion();   // <- reduced-motion aktivieren
  initScene();
});

onUnmounted(() => {
  // Loop stoppen
  stopLoop();

  // DOM entfernen
  if (renderer && renderer.domElement && containerRef.value?.contains(renderer.domElement)) {
    containerRef.value.removeChild(renderer.domElement);
  }

  // Materialien entsorgen (Geometrie via Cache, s.u.)
  cloudGroup?.traverse(obj => {
    const mesh = obj as THREE.Mesh;
    if (mesh && (mesh as any).isMesh) {
      const mat = mesh.material as THREE.Material | THREE.Material[];
      if (Array.isArray(mat)) mat.forEach(m => m.dispose());
      else mat?.dispose();
      // Geometrie-Dispose NICHT hier, da geteilt über geometryCache
    }
  });
  textMaterial?.dispose();

  // Geometrien aus dem Cache entsorgen (jede genau einmal)
  geometryCache.forEach((g) => g.dispose());
  geometryCache.clear();

  // Renderer freigeben
  if (renderer) {
    renderer.dispose();
    renderer.forceContextLoss();
    renderer = null;
  }

  // Observer & Listener abbauen
  io?.disconnect(); io = null;
  themeObserver?.disconnect(); themeObserver = null;

  if (mouseMoveListener) window.removeEventListener('mousemove', mouseMoveListener);
  if (resizeListener) window.removeEventListener('resize', resizeListener);
  if (touchMoveListener) window.removeEventListener('touchmove', touchMoveListener);
  if (touchEndListener) window.removeEventListener('touchend', touchEndListener);
  if (visibilityListener) document.removeEventListener('visibilitychange', visibilityListener);

  // reduced-motion Listener entfernen (cross-browser)
  if (prefersReducedMql && reducedMotionListener) {
    if ('removeEventListener' in prefersReducedMql) {
      prefersReducedMql.removeEventListener('change', reducedMotionListener);
    } else {
      // @ts-ignore older Safari
      prefersReducedMql.removeListener(reducedMotionListener);
    }
  }
});
</script>

<template>
  <div
    ref="containerRef"
    class="absolute top-0 left-0 w-full z-0"
    :style="{ height: containerHeight }"
  >
    <!-- Info-Box -->
    <div class="absolute top-4 right-4 z-10">
      <button
        @click="showInfoBox = !showInfoBox"
        class="p-2 rounded-full bg-black/20 text-white hover:bg-black/40 transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-white"
      >
        <Info v-if="!showInfoBox" class="h-5 w-5" />
        <X v-else class="h-5 w-5" />
      </button>
      <Transition
        enter-active-class="transition ease-out duration-200"
        enter-from-class="transform opacity-0 scale-95"
        enter-to-class="transform opacity-100 scale-100"
        leave-active-class="transition ease-in duration-150"
        leave-from-class="transform opacity-100 scale-100"
        leave-to-class="transform opacity-0 scale-95"
      >
        <div
          v-if="showInfoBox"
          class="absolute top-12 right-0 w-64 bg-white/90 dark:bg-slate-800/90 backdrop-blur-sm p-4 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700"
        >
          <h4 class="font-bold text-gray-900 dark:text-white">Interaktion</h4>
          <ul class="mt-2 text-sm text-gray-700 dark:text-gray-300 list-disc pl-5 space-y-1">
            <li><strong>Ziehen:</strong> Wolke drehen</li>
          </ul>
        </div>
      </Transition>
    </div>
  </div>
</template>


<!-- 
muss installiert werden

# Installiert die Three.js-Bibliothek
npm install three

# Installiert die TypeScript-Typen für Three.js
npm install -D @types/three

# Installiert die TWEEN.js-Bibliothek
npm install @tweenjs/tween.js

# Installiert die TypeScript-Typen für TWEEN.js
npm install -D @types/tween.js

-->
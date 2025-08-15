<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue';
import * as THREE from 'three';
import { FontLoader } from 'three/examples/jsm/loaders/FontLoader.js';
import { TextGeometry } from 'three/examples/jsm/geometries/TextGeometry.js';
import TWEEN from '@tweenjs/tween.js';

// =============================================================================
// PROPS & KONFIGURATION
// =============================================================================
const props = withDefaults(defineProps<{
    words: string[];
    cloudWidth?: number;
    cloudHeight?: number;
    cloudDepth?: number;
    wordCount?: number;
    fontUrl?: string;
    fontSize?: number;
    fontDepth?: number;
    autoRotateSpeed?: number;
    cameraHoverEffect?: boolean;
    faceCamera?: boolean;
    enableListAnimation?: boolean;
    listAnimationDelay?: number;
    listBlinkSpeed?: number;
}>(), {
    cloudWidth: 50,
    cloudHeight: 35,
    cloudDepth: 50,
    wordCount: 70,
    fontUrl: '/fonts/helvetiker_regular.typeface.json',
    fontSize: 0.7,
    fontDepth: 0.05,
    autoRotateSpeed: 0.0005,
    cameraHoverEffect: true,
    faceCamera: true,
    enableListAnimation: true,
    listAnimationDelay: 10000,
    listBlinkSpeed: 100,
});

const containerRef = ref<HTMLElement | null>(null);

// Globale Variablen für die Szene und Animation
let animationId: number | null = null;
let renderer: THREE.WebGLRenderer;
let scene: THREE.Scene;
let camera: THREE.PerspectiveCamera;
let wordMeshes: THREE.Mesh[] = [];
let cloudGroup: THREE.Group;

// KORREKTUR: Listener-Variablen werden hier deklariert, damit sie im ganzen Skript bekannt sind.
let mouseMoveListener: ((event: MouseEvent) => void) | null = null;
let touchMoveListener: ((event: TouchEvent) => void) | null = null;
let touchEndListener: (() => void) | null = null;
let resizeListener: (() => void) | null = null;

// KORREKTUR: Globale Variablen für die Mausposition
let mouseX = window.innerWidth / 2;
let mouseY = window.innerHeight / 2;

// Zustände für Interaktionen
const isMouseOver = ref(false);
const isDragging = ref(false);
const previousMousePosition = { x: 0, y: 0 };

// =============================================================================
// INITIALISIERUNG
// =============================================================================
const initScene = () => {
    if (!containerRef.value) return;
    const container = containerRef.value;

    scene = new THREE.Scene();
    camera = new THREE.PerspectiveCamera(70, container.clientWidth / container.clientHeight, 0.1, 1000);
    camera.position.z = 25;
    renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
    renderer.setPixelRatio(window.devicePixelRatio);
    renderer.setSize(container.clientWidth, container.clientHeight);
    renderer.setClearColor(0x000000, 0);
    container.appendChild(renderer.domElement);

    const fontLoader = new FontLoader();
    fontLoader.load(props.fontUrl, (font) => {
        const lightModeColor = new THREE.Color(0x1e293b);
        const darkModeColor = new THREE.Color(0xffffff);
        const textMaterial = new THREE.MeshBasicMaterial({
            color: document.documentElement.classList.contains('dark') ? darkModeColor : lightModeColor,
            transparent: true,
        });

        cloudGroup = new THREE.Group();
        wordMeshes = [];

        for (let i = 0; i < props.wordCount; i++) {
            const randomWord = props.words[Math.floor(Math.random() * props.words.length)];
            const textGeometry = new TextGeometry(randomWord, {
                font: font,
                size: props.fontSize,
                depth: props.fontDepth,
            });
            textGeometry.center();

            const textMesh = new THREE.Mesh(textGeometry, textMaterial.clone());
            
            textMesh.userData.initialPosition = new THREE.Vector3(
                (Math.random() - 0.5) * props.cloudWidth,
                (Math.random() - 0.5) * props.cloudHeight,
                (Math.random() - 0.5) * props.cloudDepth
            );
            textMesh.position.copy(textMesh.userData.initialPosition);
            
            cloudGroup.add(textMesh);
            wordMeshes.push(textMesh);
        }
        scene.add(cloudGroup);

        if (props.enableListAnimation) {
            setTimeout(startListAnimation, props.listAnimationDelay);
        }
    });

    setupEventListeners();
    // KORREKTUR: Die Animation wird jetzt korrekt mit requestAnimationFrame gestartet.
    requestAnimationFrame(animate);
};

// =============================================================================
// LISTEN-ANIMATION (Spezial-Effekt)
// =============================================================================
const startListAnimation = () => { /* ... bleibt unverändert ... */ };
const blinkList = () => { /* ... bleibt unverändert ... */ };
const returnToCloud = () => { /* ... bleibt unverändert ... */ };

// =============================================================================
// EVENT-LISTENER & INTERAKTIONEN
// =============================================================================
const setupEventListeners = () => {
    if (!containerRef.value || !renderer) return;
    const container = containerRef.value;
    renderer.domElement.style.cursor = 'grab';

    container.addEventListener('mouseenter', () => { isMouseOver.value = true; });
    container.addEventListener('mouseleave', () => { isMouseOver.value = false; });

    container.addEventListener('mousedown', (e) => {
        isDragging.value = true;
        renderer.domElement.style.cursor = 'grabbing';
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

    window.addEventListener('mouseup', () => {
        if (isDragging.value) {
            isDragging.value = false;
            renderer.domElement.style.cursor = 'grab';
        }
    });

    // KORREKTUR: Die Funktion wird jetzt korrekt der Variable zugewiesen.
    touchEndListener = () => {
        if (isDragging.value) isDragging.value = false;
    };
    window.addEventListener('touchend', touchEndListener);
    
    const handleDrag = (clientX: number, clientY: number) => {
        if (isDragging.value) {
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
        if (event.touches.length === 1) {
            handleDrag(event.touches[0].clientX, event.touches[0].clientY);
        }
    };
    window.addEventListener('touchmove', touchMoveListener);

    resizeListener = () => {
        if (containerRef.value) {
            renderer.setSize(containerRef.value.clientWidth, containerRef.value.clientHeight);
            camera.aspect = containerRef.value.clientWidth / containerRef.value.clientHeight;
            camera.updateProjectionMatrix();
        }
    };
    window.addEventListener('resize', resizeListener);
};

// =============================================================================
// ANIMATIONS-SCHLEIFE
// =============================================================================
const animate = (time: number) => {
    animationId = requestAnimationFrame(animate);
    TWEEN.update(time);

    if (cloudGroup && !isDragging.value) {
        cloudGroup.rotation.y += props.autoRotateSpeed;
    }

    if (props.cameraHoverEffect && !isDragging.value) {
        if (isMouseOver.value) {
            camera.position.x += ((mouseX - window.innerWidth / 2) / 400 - camera.position.x) * 0.05;
            camera.position.y += (-(mouseY - window.innerHeight / 2) / 400 - camera.position.y) * 0.05;
        } else {
            camera.position.x += (0 - camera.position.x) * 0.05;
            camera.position.y += (0 - camera.position.y) * 0.05;
        }
    }

    if (props.faceCamera && wordMeshes) {
        wordMeshes.forEach(mesh => {
            mesh.lookAt(camera.position);
        });
    }

    if(scene && camera) {
        camera.lookAt(scene.position);
        renderer.render(scene, camera);
    }
};

// =============================================================================
// LIFECYCLE HOOKS
// =============================================================================
onMounted(() => {
    setTimeout(initScene, 200);
});

onUnmounted(() => {
    if (animationId) cancelAnimationFrame(animationId);
    if (renderer) {
        if (renderer.domElement && containerRef.value?.contains(renderer.domElement)) {
            containerRef.value.removeChild(renderer.domElement);
        }
        renderer.dispose();
        renderer.forceContextLoss();
    }
    if (mouseMoveListener) window.removeEventListener('mousemove', mouseMoveListener);
    if (resizeListener) window.removeEventListener('resize', resizeListener);
    if (touchMoveListener) window.removeEventListener('touchmove', touchMoveListener);
    if (touchEndListener) window.removeEventListener('touchend', touchEndListener);
});
</script>

<template>
  <div ref="containerRef" class="absolute inset-0 z-0"></div>
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
<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue';
import * as THREE from 'three';
import { FontLoader } from 'three/examples/jsm/loaders/FontLoader.js';
import { TextGeometry } from 'three/examples/jsm/geometries/TextGeometry.js';
import * as BufferGeometryUtils from 'three/examples/jsm/utils/BufferGeometryUtils.js';

const props = defineProps<{
  words: string[];
}>();

const containerRef = ref<HTMLElement | null>(null);

let animationId: number | null = null;
let renderer: any;
let mouseMoveListener: ((event: MouseEvent) => void) | null = null;
let resizeListener: (() => void) | null = null;

// Wir lagern die gesamte Initialisierung in eine eigene Funktion aus
const initScene = () => {
    if (!containerRef.value) return;

    const container = containerRef.value;
    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(70, window.innerWidth / window.innerHeight, 0.1, 1000);
    camera.position.z = 25;

    renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
    renderer.setPixelRatio(window.devicePixelRatio);
    renderer.setSize(window.innerWidth, window.innerHeight);
    renderer.setClearColor(0x000000, 0);
    
    // Wichtig: Das Canvas ist anfangs unsichtbar
    renderer.domElement.style.opacity = '0';
    renderer.domElement.style.transition = 'opacity 1s';
    
    container.appendChild(renderer.domElement);

    const fontLoader = new FontLoader();
    fontLoader.load('/fonts/helvetiker_regular.typeface.json', (font) => {
        const lightModeColor = new THREE.Color(0x1e293b);
        const darkModeColor = new THREE.Color(0xffffff);
        const textMaterial = new THREE.MeshBasicMaterial({
            color: document.documentElement.classList.contains('dark') ? darkModeColor : lightModeColor,
        });

        const geometries: TextGeometry[] = [];
        const wordCount = 150;
        const dummy = new THREE.Object3D();

        for (let i = 0; i < wordCount; i++) {
            const randomWord = props.words[Math.floor(Math.random() * props.words.length)];
            const textGeometry = new TextGeometry(randomWord, {
                font: font, size: 0.3, depth: 0.02,
            });
            dummy.position.set(
                (Math.random() - 0.5) * 50, 
                (Math.random() - 0.5) * 40, 
                (Math.random() - 0.5) * 40
            );
            dummy.rotation.set(
                (Math.random() - 0.5) * (Math.PI / 2), // Begrenzt die Drehung auf +/- 45 Grad auf der X-Achse
                (Math.random() - 0.5) * (Math.PI / 2), // Begrenzt die Drehung auf +/- 45 Grad auf der Y-Achse
                (Math.random() - 0.5) * (Math.PI / 4)  // Fügt eine leichte Drehung um die Z-Achse für mehr Dynamik hinzu
            );

            dummy.updateMatrix();
            textGeometry.applyMatrix4(dummy.matrix);
            geometries.push(textGeometry);
        }

        const mergedGeometry = BufferGeometryUtils.mergeGeometries(geometries);
        const textCloud = new THREE.Mesh(mergedGeometry, textMaterial);
        scene.add(textCloud);

        // Sobald alles berechnet ist, blenden wir das Canvas ein
        renderer.domElement.style.opacity = '1';

        let mouseX = 0, mouseY = 0;
        mouseMoveListener = (event: MouseEvent) => {
            mouseX = event.clientX;
            mouseY = event.clientY;
            
        };
        window.addEventListener('mousemove', mouseMoveListener);

        const animate = () => {
            animationId = requestAnimationFrame(animate);
            const isDarkMode = document.documentElement.classList.contains('dark');
            const targetColor = isDarkMode ? darkModeColor : lightModeColor;
            if (textMaterial.color.getHex() !== targetColor.getHex()) {
                textMaterial.color.set(targetColor);
            }
            textCloud.rotation.y += 0.0015;
            textCloud.rotation.x += 0.0001;
            //textCloud.rotation.z += 0.0005;
            camera.position.x += ((mouseX - window.innerWidth / 2) / 400 - camera.position.x) * 0.15;
            camera.position.y += (-(mouseY - window.innerHeight / 2) / 400 - camera.position.y) * 0.45;
            //camera.position.z += (-(mouseY - window.innerHeight / 3) / 400 - camera.position.y) * 0.01;
            camera.lookAt(scene.position);
            renderer.render(scene, camera);
        };
        animate();
    });

    resizeListener = () => {
        renderer.setSize(window.innerWidth, window.innerHeight);
        camera.aspect = window.innerWidth / window.innerHeight;
        camera.updateProjectionMatrix();
    };
    window.addEventListener('resize', resizeListener);
};

onMounted(() => {
    // Wir warten 200 Millisekunden, damit die Hauptseite erst rendern kann,
    // und starten DANN die aufwendige 3D-Initialisierung.
    setTimeout(initScene, 200);
});

onUnmounted(() => {
    if (animationId) cancelAnimationFrame(animationId);
    if (renderer) {
        renderer.dispose();
        renderer.forceContextLoss();
    }
    if (mouseMoveListener) window.removeEventListener('mousemove', mouseMoveListener);
    if (resizeListener) window.removeEventListener('resize', resizeListener);
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




-->
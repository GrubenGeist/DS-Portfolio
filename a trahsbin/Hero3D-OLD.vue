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
// NEU: Touch-Listener-Variablen
let touchMoveListener: ((event: TouchEvent) => void) | null = null;
let touchEndListener: (() => void) | null = null;


// Zustand für den Hover-Effekt
const isMouseOver = ref(false);
// Zustände für die Drag-to-Rotate-Funktionalität
const isDragging = ref(false);
const previousMousePosition = { x: 0, y: 0 };

const initScene = () => {
    if (!containerRef.value) return;

    const container = containerRef.value;
    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(70, container.clientWidth / container.clientHeight, 0.1, 1000);
    camera.position.z = 25;

    renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
    renderer.setPixelRatio(window.devicePixelRatio);
    renderer.setSize(container.clientWidth, container.clientHeight);
    renderer.setClearColor(0x000000, 0);
    
    renderer.domElement.style.opacity = '0';
    renderer.domElement.style.transition = 'opacity 1s';
    renderer.domElement.style.cursor = 'grab';
    
    container.appendChild(renderer.domElement);

    // Event-Listener für den Hover-Effekt (Desktop)
    container.addEventListener('mouseenter', () => { isMouseOver.value = true; });
    container.addEventListener('mouseleave', () => { isMouseOver.value = false; });

    // Event-Listener für das Dragging (Desktop)
    container.addEventListener('mousedown', (e) => {
        isDragging.value = true;
        renderer.domElement.style.cursor = 'grabbing';
        previousMousePosition.x = e.clientX;
        previousMousePosition.y = e.clientY;
    });
    
    // NEU: Event-Listener für das Dragging (Mobile)
    container.addEventListener('touchstart', (e) => {
        if (e.touches.length === 1) {
            isDragging.value = true;
            previousMousePosition.x = e.touches[0].clientX;
            previousMousePosition.y = e.touches[0].clientY;
        }
    }, { passive: true });

    // Globale Listener für das Ende des Ziehens
    window.addEventListener('mouseup', () => {
        if (isDragging.value) {
            isDragging.value = false;
            renderer.domElement.style.cursor = 'grab';
        }
    });
    touchEndListener = () => {
        if (isDragging.value) {
            isDragging.value = false;
        }
    };
    window.addEventListener('touchend', touchEndListener);


    const fontLoader = new FontLoader();
    fontLoader.load('/fonts/helvetiker_regular.typeface.json', (font) => {
        const lightModeColor = new THREE.Color(0x1e293b);
        const darkModeColor = new THREE.Color(0xffffff);
        const textMaterial = new THREE.MeshBasicMaterial({
            color: document.documentElement.classList.contains('dark') ? darkModeColor : lightModeColor,
        });

        // Die Erstellung der Wort-Wolke bleibt unverändert.
        const geometries: TextGeometry[] = [];
        const wordCount = 70;
        const dummy = new THREE.Object3D();
        for (let i = 0; i < wordCount; i++) {
            const randomWord = props.words[Math.floor(Math.random() * props.words.length)];
            const textGeometry = new TextGeometry(randomWord, { font: font, size: 1.0, depth: 0.04 });
            dummy.position.set((Math.random() - 0.5) * 50, (Math.random() - 0.5) * 35, (Math.random() - 0.5) * 50);
            dummy.rotation.set((Math.random() - 0.5) * (Math.PI / 10.5), (Math.random() - 0.5) * (Math.PI / 0.001), (Math.random() - 0.5) * (Math.PI / 10));
            dummy.updateMatrix();
            textGeometry.applyMatrix4(dummy.matrix);
            geometries.push(textGeometry);
        }
        const mergedGeometry = BufferGeometryUtils.mergeGeometries(geometries);
        const textCloud = new THREE.Mesh(mergedGeometry, textMaterial);
        scene.add(textCloud);

        renderer.domElement.style.opacity = '1';

        let mouseX = window.innerWidth / 2;
        let mouseY = window.innerHeight / 2;
        
        const handleDrag = (clientX: number, clientY: number) => {
            if (isDragging.value) {
                const deltaX = clientX - previousMousePosition.x;
                const deltaY = clientY - previousMousePosition.y;

                textCloud.rotation.y += deltaX * 0.005;
                textCloud.rotation.x += deltaY * 0.005;

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

        // NEU: Touchmove-Listener
        touchMoveListener = (event: TouchEvent) => {
            if (event.touches.length === 1) {
                handleDrag(event.touches[0].clientX, event.touches[0].clientY);
            }
        };
        window.addEventListener('touchmove', touchMoveListener);

        const animate = () => {
            animationId = requestAnimationFrame(animate);
            const isDarkMode = document.documentElement.classList.contains('dark');
            const targetColor = isDarkMode ? darkModeColor : lightModeColor;
            if (textMaterial.color.getHex() !== targetColor.getHex()) {
                textMaterial.color.set(targetColor);
            }
            
            if (!isDragging.value) {
                textCloud.rotation.y += 0.0005;
            }

            if (!isDragging.value) {
                if (isMouseOver.value) {
                    camera.position.x += ((mouseX - window.innerWidth / 2) / 400 - camera.position.x) * 0.05;
                    camera.position.y += (-(mouseY - window.innerHeight / 2) / 400 - camera.position.y) * 0.05;
                } else {
                    camera.position.x += (0 - camera.position.x) * 0.05;
                    camera.position.y += (0 - camera.position.y) * 0.05;
                }
            }

            camera.lookAt(scene.position);
            renderer.render(scene, camera);
        };
        animate();
    });

    resizeListener = () => {
        if (containerRef.value) {
            renderer.setSize(containerRef.value.clientWidth, containerRef.value.clientHeight);
            camera.aspect = containerRef.value.clientWidth / containerRef.value.clientHeight;
            camera.updateProjectionMatrix();
        }
    };
    window.addEventListener('resize', resizeListener);
};

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
    // NEU: Touch-Listener entfernen
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




-->
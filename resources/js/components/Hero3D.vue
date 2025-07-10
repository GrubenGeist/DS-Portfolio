<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue';
import * as THREE from 'three';
import { FontLoader } from 'three/examples/jsm/loaders/FontLoader.js';
import { TextGeometry } from 'three/examples/jsm/geometries/TextGeometry.js';
// NEU: Wir importieren ein Werkzeug zum Verschmelzen von Geometrien
import * as BufferGeometryUtils from 'three/examples/jsm/utils/BufferGeometryUtils.js';

const props = defineProps<{
  words: string[];
}>();

const containerRef = ref<HTMLElement | null>(null);

let animationId: number | null = null;
let renderer: any;
let mouseMoveListener: ((event: MouseEvent) => void) | null = null;
let resizeListener: (() => void) | null = null;

onMounted(() => {
    if (!containerRef.value) return;

    const THREE_ = THREE;
    const container = containerRef.value;

    const scene = new THREE_.Scene();
    const camera = new THREE_.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
    camera.position.z = 25;

    renderer = new THREE_.WebGLRenderer({ antialias: true, alpha: true });
    renderer.setPixelRatio(window.devicePixelRatio);
    renderer.setSize(window.innerWidth, window.innerHeight);
    renderer.setClearColor(0x000000, 0);
    container.appendChild(renderer.domElement);

    const fontLoader = new FontLoader();
    fontLoader.load('/fonts/helvetiker_regular.typeface.json', (font) => {
        
        const lightModeColor = new THREE_.Color(0x1e293b);
        const darkModeColor = new THREE_.Color(0xffffff);
        
        const textMaterial = new THREE_.MeshBasicMaterial({
            color: document.documentElement.classList.contains('dark') ? darkModeColor : lightModeColor,
        });

        // --- NEUE LOGIK: GEOMETRIEN ERSTELLEN UND VERSCHMELZEN ---
        const geometries: TextGeometry[] = [];
        const wordCount = 150;
        const dummy = new THREE_.Object3D(); // Ein Hilfsobjekt für die Positionierung

        for (let i = 0; i < wordCount; i++) {
            const randomWord = props.words[Math.floor(Math.random() * props.words.length)];
            const textGeometry = new TextGeometry(randomWord, {
                font: font,
                size: 0.3,
                depth: 0.02, // Korrekter Parameter 'depth'
            });

            // Wir positionieren und rotieren das Hilfsobjekt
            dummy.position.set(
                (Math.random() - 0.5) * 50,
                (Math.random() - 0.5) * 40,
                (Math.random() - 0.5) * 40
            );
            dummy.rotation.set(
                Math.random() * Math.PI,
                Math.random() * Math.PI,
                0
            );
            dummy.updateMatrix();

            // Wir wenden die Position/Rotation direkt auf die Geometrie an
            textGeometry.applyMatrix4(dummy.matrix);

            geometries.push(textGeometry);
        }

        // Alle einzelnen Geometrien werden zu einer einzigen verschmolzen
        const mergedGeometry = BufferGeometryUtils.mergeGeometries(geometries);
        // Wir erstellen nur EIN Mesh-Objekt für alle Wörter
        const textCloud = new THREE_.Mesh(mergedGeometry, textMaterial);
        scene.add(textCloud);

        // Animations-Loop
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

            // Wir animieren die gesamte Wolke aus Text
            textCloud.rotation.y += 0.0005;
            textCloud.rotation.x += 0.0005;

            camera.position.x += ((mouseX - window.innerWidth / 2) / 400 - camera.position.x) * 1.05;
            camera.position.y += (-(mouseY - window.innerHeight / 2) / 400 - camera.position.y) * 1.05;
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
<script setup lang="ts">
import { ref, onMounted, onUnmounted, computed } from 'vue';

// Das Interface für die Props, die von der "Über Mich"-Seite kommen
interface Skill {
  name: string;
  ring: 'core' | 'proficient' | 'exploring';
  color: string;
  logoUrl: string;
  description: string;
}

const props = defineProps<{
  skills: Skill[];
}>();

const positionedSkills = ref<any[]>([]);
const selectedSkill = ref<Skill | null>(null);
const animationFrameId = ref<number | null>(null);
const isMobile = ref(false);

const isPaused = computed(() => !!selectedSkill.value);

// Initialisiert die Skills mit zufälligen Positionen und Geschwindigkeiten
const initializeSkills = () => {
  positionedSkills.value = props.skills.map(skill => ({
    ...skill,
    x: Math.random() * 600 + 50,
    y: Math.random() * 600 + 50,
    vx: (Math.random() - 0.5) * 0.5,
    vy: (Math.random() - 0.5) * 0.5,
    wanderAngle: Math.random() * 2 * Math.PI,
  }));
};

// Die Haupt-Animationsschleife für die Desktop-Ansicht
const runSimulation = () => {
  if (!isPaused.value && !isMobile.value) {
    const containerSize = 700;
    const center = { x: containerSize / 2, y: containerSize / 2 };
    const minDistance = 115;
    const repulsionStrength = 0.05;
    const damping = 0.99;

    positionedSkills.value.forEach((p1, i) => {
      positionedSkills.value.forEach((p2, j) => {
        if (i === j) return;
        const dx = p2.x - p1.x;
        const dy = p2.y - p1.y;
        const distance = Math.hypot(dx, dy);

        if (distance < minDistance) {
          const force = (minDistance - distance) * repulsionStrength;
          const angle = Math.atan2(dy, dx);
          p1.vx -= Math.cos(angle) * force;
          p1.vy -= Math.sin(angle) * force;
        }
      });

      const wanderStrength = 0.03;
      p1.wanderAngle += (Math.random() - 0.5) * 0.1; 
      p1.vx += Math.cos(p1.wanderAngle) * wanderStrength;
      p1.vy += Math.sin(p1.wanderAngle) * wanderStrength;

      // KORREKTUR: Eine sanfte Zentrierungskraft wird hinzugefügt, um die Sechsecke
      // in der Mitte des Containers zu halten und dem Auseinandertreiben entgegenzuwirken.
      const centeringStrength = 0.0002; // Sehr schwache Kraft für einen organischen Effekt
      const dxCenter = center.x - p1.x;
      const dyCenter = center.y - p1.y;
      p1.vx += dxCenter * centeringStrength;
      p1.vy += dyCenter * centeringStrength;

      p1.vx *= damping;
      p1.vy *= damping;
      p1.x += p1.vx;
      p1.y += p1.vy;

      const bufferX = 90 / 2;
      const bufferY = 104 / 2;
      if (p1.x < bufferX) { p1.x = bufferX; p1.vx *= -0.5; }
      if (p1.x > containerSize - bufferX) { p1.x = containerSize - bufferX; p1.vx *= -1.5; }
      if (p1.y < bufferY) { p1.y = bufferY; p1.vy *= -0.5; }
      if (p1.y > containerSize - bufferY) { p1.y = containerSize - bufferY; p1.vy *= -1.5; }
    });
  }
  animationFrameId.value = requestAnimationFrame(runSimulation);
};

const selectSkill = (skill: Skill) => {
  selectedSkill.value = skill;
};

const deselectSkill = () => {
  selectedSkill.value = null;
};

const checkScreenSize = () => {
  isMobile.value = window.innerWidth < 768;
};

onMounted(() => {
  checkScreenSize();
  window.addEventListener('resize', checkScreenSize);

  if (!isMobile.value) {
    initializeSkills();
    runSimulation();
  }
});

onUnmounted(() => {
  window.removeEventListener('resize', checkScreenSize);
  if (animationFrameId.value) {
    cancelAnimationFrame(animationFrameId.value);
  }
});
</script>

<template>
  <div 
    class="relative w-full max-w-[700px] mx-auto aspect-square radar-container"
    :class="{ 'is-paused': isPaused }"
  >
    <div 
      v-if="isPaused" 
      @click="deselectSkill" 
      class="absolute inset-0 z-10 cursor-pointer"
    ></div>

    <!-- Container für die Desktop-Animation -->
    <div v-if="!isMobile" class="w-full h-full">
        <div
        v-for="(skill, index) in positionedSkills"
        :key="index"
        class="absolute"
        :style="{ 
            top: `${skill.y}px`, 
            left: `${skill.x}px`, 
            transform: 'translate(-50%, -50%)' 
        }"
        @click.stop="selectSkill(skill)"
        >
            <div class="hexagon-wrapper group">
            <div class="hexagon" :style="{ backgroundColor: skill.color }">
                <img 
                :src="skill.logoUrl" 
                :alt="`${skill.name} Logo`" 
                class="w-10 h-10 object-contain transition-transform duration-300 group-hover:scale-110"
                onerror="this.onerror=null;this.src='https://placehold.co/40x40/transparent/white?text=%3F';"
                loading="lazy"
                />
            </div>
            <div class="hexagon-overlay">
                <span class="text-white font-bold text-xs">{{ skill.name }}</span>
            </div>
            </div>
        </div>
    </div>
    
    <!-- Container für das mobile Grid -->
    <div v-else class="flex flex-wrap items-center justify-center gap-4 p-4">
        <div
            v-for="skill in skills"
            :key="skill.name"
            @click.stop="selectSkill(skill)"
        >
            <div class="hexagon-wrapper group">
            <div class="hexagon" :style="{ backgroundColor: skill.color }">
                <img 
                :src="skill.logoUrl" 
                :alt="`${skill.name} Logo`" 
                class="w-10 h-10 object-contain transition-transform duration-300 group-hover:scale-110"
                onerror="this.onerror=null;this.src='https://placehold.co/40x40/transparent/white?text=%3F';"
                loading="lazy"
                />
            </div>
            <div class="hexagon-overlay">
                <span class="text-white font-bold text-xs">{{ skill.name }}</span>
            </div>
            </div>
        </div>
    </div>


    <!-- Die Infokarte (funktioniert für beide Ansichten) -->
    <transition
      enter-active-class="transition ease-out duration-300"
      enter-from-class="opacity-0 scale-95"
      enter-to-class="opacity-100 scale-100"
      leave-active-class="transition ease-in duration-200"
      leave-from-class="opacity-100 scale-100"
      leave-to-class="opacity-0 scale-95"
    >
      <div v-if="selectedSkill" class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-20 w-64 p-4 bg-white dark:bg-slate-800 rounded-lg shadow-2xl border dark:border-slate-700">
        <div class="flex items-center gap-3">
          <div class="hexagon-wrapper-small">
            <div class="hexagon-small flex items-center justify-center" :style="{ backgroundColor: selectedSkill.color }">
              <img :src="selectedSkill.logoUrl" :alt="`${selectedSkill.name} Logo`" class="w-6 h-6 object-contain" />
            </div>
          </div>
          <h3 class="font-bold text-lg text-gray-900 dark:text-white">{{ selectedSkill.name }}</h3>
        </div>
        <p class="mt-3 text-sm text-gray-600 dark:text-gray-400">
          {{ selectedSkill.description }}
        </p>
        <button @click="deselectSkill" class="mt-4 w-full text-center text-sm font-semibold text-indigo-600 dark:text-indigo-400 hover:underline">
          Schließen
        </button>
      </div>
    </transition>
  </div>
</template>

<style>
.hexagon-wrapper {
  position: relative;
  width: 90px;
  height: 104px;
  cursor: pointer;
  transition: transform 0.3s ease-in-out;
}
.hexagon-wrapper:hover {
    transform: scale(1.1);
}

.hexagon, .hexagon-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
    display: flex;
    align-items: center;
    justify-content: center;
}
.hexagon-overlay {
    background-color: rgba(0,0,0,0.5);
    opacity: 0;
    transition: opacity 0.3s ease-in-out;
}
.hexagon-wrapper:hover .hexagon-overlay {
    opacity: 1;
}

/* Stile für das kleine Hexagon in der Infokarte */
.hexagon-wrapper-small {
  position: relative;
  width: 44px;
  height: 50.8px;
  flex-shrink: 0;
}
.hexagon-small {
  width: 100%;
  height: 100%;
  clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
}
</style>

<script setup lang="ts">
import { ref, onMounted, onUnmounted, computed, nextTick, watch } from 'vue';

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

const scrollContainer = ref<HTMLElement | null>(null);
const skillElements = ref<HTMLElement[]>([]);
const activeSkillIndex = ref(0);

const canScrollLeft = computed(() => activeSkillIndex.value > 0);
const canScrollRight = computed(() => activeSkillIndex.value < props.skills.length - 1);

const selectedSkill = computed(() => {
  return props.skills[activeSkillIndex.value] || null;
});

let isProgrammaticScroll = ref(false);
// KORREKTUR: Der Typ wird so angepasst, dass er sowohl die Browser- als auch die Node.js-Rückgabetypen von setTimeout akzeptiert.
let scrollTimeout: ReturnType<typeof setTimeout> | null = null;

// Die Pfeil-Klicks aktualisieren jetzt direkt den Index.
const scrollLeft = () => {
  if (isProgrammaticScroll.value || !canScrollLeft.value) return;
  activeSkillIndex.value--;
};

const scrollRight = () => {
  if (isProgrammaticScroll.value || !canScrollRight.value) return;
  activeSkillIndex.value++;
};

// Ein Watcher reagiert auf Index-Änderungen und führt den Scroll-Befehl aus.
watch(activeSkillIndex, (newIndex, oldIndex) => {
  // Verhindert unnötige Aktionen, wenn der Index sich nicht ändert
  if (newIndex === oldIndex) return;

  isProgrammaticScroll.value = true;
  skillElements.value[newIndex]?.scrollIntoView({
    behavior: 'smooth',
    inline: 'center',
    block: 'nearest'
  });
  // Setzt den Flag nach der Scroll-Animation zurück
  setTimeout(() => {
    isProgrammaticScroll.value = false;
  }, 500); // 500ms sollte für die smooth-scroll Animation ausreichen
});

// KORREKTUR: Ersetzt den IntersectionObserver durch einen robusteren,
// debounced Scroll-Handler für manuelle Touch-Scrolls.
const handleManualScroll = () => {
    if (isProgrammaticScroll.value || !scrollContainer.value) return;

    if (scrollTimeout) {
        clearTimeout(scrollTimeout);
    }

    // Wartet, bis das Scrollen beendet ist, und ermittelt dann das mittlere Element.
    scrollTimeout = setTimeout(() => {
        const containerCenter = scrollContainer.value!.scrollLeft + scrollContainer.value!.offsetWidth / 2;
        
        let closestIndex = -1;
        let minDistance = Infinity;

        skillElements.value.forEach((el, index) => {
            const elCenter = el.offsetLeft + el.offsetWidth / 2;
            const distance = Math.abs(containerCenter - elCenter);
            if (distance < minDistance) {
                minDistance = distance;
                closestIndex = index;
            }
        });

        if (closestIndex !== -1 && activeSkillIndex.value !== closestIndex) {
            activeSkillIndex.value = closestIndex;
        }
    }, 150); // Wartet 150ms nach dem letzten Scroll-Event
};


onMounted(() => {
  nextTick(() => {
    if (skillElements.value[0]) {
        skillElements.value[0].scrollIntoView({ behavior: 'auto', inline: 'center', block: 'nearest' });
    }
  });
  
  scrollContainer.value?.addEventListener('scroll', handleManualScroll);
});

onUnmounted(() => {
  scrollContainer.value?.removeEventListener('scroll', handleManualScroll);
});
</script>

<template>
  <div class="w-full relative group/container">
    <!-- Der horizontale Scroll-Container -->
    <div ref="scrollContainer" class="scroll-container max-w-4xl mx-auto">
      <div class="scroll-spacer"></div>
      <div
        v-for="(skill, index) in skills"
        :key="skill.name"
        :ref="el => { if (el) skillElements[index] = el as HTMLElement }"
        :data-index="index"
        class="skill-item"
        :class="{ 'is-active': index === activeSkillIndex }"
      >
        <div class="hexagon-wrapper">
          <div class="hexagon" :style="{ backgroundColor: skill.color }">
            <img 
              :src="skill.logoUrl" 
              :alt="`${skill.name} Logo`" 
              class="w-12 h-12 object-contain"
              loading="lazy"
            />
          </div>
        </div>
      </div>
      <div class="scroll-spacer"></div>
    </div>

    <!-- Navigations-Pfeile -->
    <button v-if="canScrollLeft" @click="scrollLeft" class="nav-arrow left-2 sm:left-4">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
    </button>
    <button v-if="canScrollRight" @click="scrollRight" class="nav-arrow right-2 sm:right-4">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
    </button>

    <!-- Die Infokarte, die sich dynamisch aktualisiert -->
    <transition
      enter-active-class="transition ease-out duration-300"
      enter-from-class="opacity-0 translate-y-4"
      enter-to-class="opacity-100 translate-y-0"
      leave-active-class="transition ease-in duration-200"
      leave-from-class="opacity-100 translate-y-0"
      leave-to-class="opacity-0 translate-y-4"
      mode="out-in"
    >
      <div v-if="selectedSkill" :key="selectedSkill.name" class="mt-8 text-center max-w-md mx-auto">
        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ selectedSkill.name }}</h3>
        <p class="mt-2 text-base text-gray-600 dark:text-gray-400 min-h-[48px]">
          {{ selectedSkill.description }}
        </p>
      </div>
    </transition>
  </div>
</template>

<style>
.scroll-container {
  display: flex;
  overflow-x: auto;
  overflow-y: hidden; /* Verhindert vertikales Scrollen */
  scroll-snap-type: x mandatory;
  -webkit-overflow-scrolling: touch;
  scrollbar-width: none; /* Firefox */
}
.scroll-container::-webkit-scrollbar {
  display: none; /* Chrome, Safari, etc. */
}

.skill-item {
  flex: 0 0 auto;
  padding: 2rem;
  scroll-snap-align: center;
  transition: transform 0.4s cubic-bezier(0.25, 0.8, 0.25, 1), opacity 0.4s;
  transform: scale(0.7);
  opacity: 0.5;
}

.skill-item.is-active {
  transform: scale(1.1);
  opacity: 1;
}

.skill-item.is-active .hexagon-wrapper {
    filter: drop-shadow(0px 10px 15px rgba(0, 0, 0, 0.3));
}

.scroll-spacer {
  flex: 0 0 50%;
  transform: translateX(-110px);
}

.nav-arrow {
  position: absolute;
  top: 83px; 
  transform: translateY(-50%);
  z-index: 10;
  display: flex;
  align-items: center;
  justify-content: center;
  width: 40px;
  height: 40px;
  background-color: rgba(100, 116, 139, 0.2);
  backdrop-filter: blur(4px);
  border-radius: 50%;
  color: white;
  transition: background-color 0.2s, opacity 0.3s;
  opacity: 0.6;
}

.group\/container:hover .nav-arrow {
    opacity: 1;
}

.nav-arrow:hover {
  background-color: rgba(100, 116, 139, 0.4);
}

.hexagon-wrapper {
  position: relative;
  width: 110px;
  height: 127px;
  transition: filter 0.4s;
}
.hexagon {
  width: 100%;
  height: 100%;
  clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
  display: flex;
  align-items: center;
  justify-content: center;
}
</style>

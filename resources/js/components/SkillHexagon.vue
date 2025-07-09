<script setup lang="ts">
// Das Interface für die Props
interface Skill {
  name: string;
  color: string;
  logoUrl: string;
}

defineProps<{
  skill: Skill;
}>();
</script>

<template>
    <div class="hexagon-wrapper group">
        <div class="hexagon flex items-center justify-center" :style="{ backgroundColor: skill.color }">
            <img 
                :src="skill.logoUrl" 
                :alt="`${skill.name} Logo`" 
                class="w-12 h-12 object-contain transition-transform duration-300 group-hover:scale-110" 
            />
        </div>
        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 bg-black/50 hexagon-overlay">
            <span class="text-white font-bold text-sm">{{ skill.name }}</span>
        </div>
    </div>
</template>

<style>
.hexagon-wrapper {
  position: relative;
  width: 110px; /* Fester Wert für Konsistenz */
  height: 127px; /* Fester Wert für das korrekte Seitenverhältnis */
  margin: 5px;
  cursor: pointer;
}

.hexagon, .hexagon-overlay {
  width: 100%;
  height: 100%;
  /* Die magische CSS-Eigenschaft, die die Sechseck-Form erzeugt */
  clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
}

.hexagon {
  transition: transform 0.3s ease-in-out;
}

.hexagon-wrapper:hover .hexagon {
    transform: scale(1.1);
}
</style>
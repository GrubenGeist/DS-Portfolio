<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue';

//LOGIK FÜR EASTER EGG 
const showGhostButton = ref(false); // Startet standardmäßig unsichtbar
const isDarkMode = ref(false);
let ghostTimeoutId: number | null = null;

// Eine Liste möglicher Texte für den Button
const GHOST_TEXTS = [
    '? ? ?', 
    'Error 404', 
    '0000', 
    '..undefined..', 
    'NaN', 
    'It’s getting worse.', 
    'there is something strage', 
    'Something’s here.',
    'It burns!',
];
// Eine reaktive Variable, die den aktuellen Text des Buttons speichert
const ghostButtonText = ref('???');

function setRandomGhostText() {
    const randomIndex = Math.floor(Math.random() * GHOST_TEXTS.length);
    ghostButtonText.value = GHOST_TEXTS[randomIndex];
}

function scheduleGhostlyReappearance() {
    const randomDelay = Math.random() * 20000 + 10000;
    if (ghostTimeoutId) clearTimeout(ghostTimeoutId);

    ghostTimeoutId = window.setTimeout(() => {
        setRandomGhostText();
        showGhostButton.value = true;
        localStorage.removeItem('ghostButtonHidden');
    }, randomDelay);
}

function handleGhostClick() {
    showGhostButton.value = false;
    localStorage.setItem('ghostButtonHidden', 'true');
    scheduleGhostlyReappearance(); 
}

onMounted(() => {
    isDarkMode.value = document.documentElement.classList.contains('dark');
    const wasHidden = localStorage.getItem('ghostButtonHidden') === 'true';

    if (!wasHidden) {
        if (Math.random() > 0.9) { // 0.01 = Wahrscheinlichkeit von 99% - 0.99 = Wahrscheinlichkeit von 1% 
            setRandomGhostText();
            showGhostButton.value = true;
        }
    } else {
        scheduleGhostlyReappearance();
    }
    
    const observer = new MutationObserver(() => {
        isDarkMode.value = document.documentElement.classList.contains('dark');
    });
    observer.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });
    
    onUnmounted(() => {
        observer.disconnect();
        if (ghostTimeoutId) clearTimeout(ghostTimeoutId);
    });
});
</script>

<template>
    <Transition name="ghost">
        <button
            v-if="isDarkMode && showGhostButton"
            @click="handleGhostClick"
            class="glitch-button flex items-center gap-3 rounded-md border border-cyan-300/20 px-3 py-2"
            :data-text="ghostButtonText"
        >
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 text-cyan-300/50"><path d="M6 4h8a4 4 0 0 1 4 4v8a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8a4 4 0 0 1 4-4Z"></path><path d="M12 18a6 6 0 0 0-6-6 6 6 0 0 1 6-6"></path></svg>
            <span class="text-cyan-300/50">{{ ghostButtonText }}</span>
        </button>
    </Transition>
</template>

<style>
/* Transition für den 'verschwinden'-Effekt (bleibt unverändert) */
.ghost-leave-active {
  transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}
.ghost-leave-to {
  opacity: 0;
  transform: translateY(-20px) scale(0.8);
}

/* EINFACHERER GLITCH-EFFEKT  */
.glitch-button {
  /* Wir wenden die Animation direkt auf den Button an */
  animation: glitch-jiggle 4s infinite alternate;
}

@keyframes glitch-jiggle {
  /* Der Button ist die meiste Zeit ruhig */
  0%, 10%, 12%, 80%, 82%, 100% {
    transform: translate(0, 0);
    text-shadow: none;
  }
  
  /* Kurze, schnelle "Glitches" zwischendurch */
  11% {
    transform: translate(-1px, 1px);
    text-shadow:
      1px 0 0 rgba(255, 0, 255, 0.7),
      -6px 0 0 rgba(0, 255, 255, 0.7);
  }

  81% {
    transform: translate(1px, -1px);
    text-shadow:
      6px 0 0 rgba(255, 0, 255, 0.7),
      -1px 0 0 rgba(0, 255, 255, 0.7);
  }
  7% {
    transform: translate(-1px, 1px);
    text-shadow:
      1px 4 0 rgba(255, 0, 255, 0.7),
      -8px 0 4 rgba(0, 255, 255, 0.7);
  }

}
</style>

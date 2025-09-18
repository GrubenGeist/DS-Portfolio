<script setup lang="ts">
import { ref, computed } from 'vue';

// PROPS
const props = defineProps<{
  frontImageUrl: string;
  backImageUrl: string;
  characterImageUrl?: string;
  audioUrl?: string;
}>();

// STATE
const cardWrapper = ref<HTMLElement | null>(null);
const isFlipped = ref(true); 
const tiltX = ref(0);
const tiltY = ref(0);
const scale = ref(1);

//ABSPIELEN EINES SOUNDS
function playAudio() {
  if (props.audioUrl) {
    const audio = new Audio(props.audioUrl);
    audio.play();
  }
}

// LOGIK
function flipCard() {
  // Zuerst den Zustand umschalten
  isFlipped.value = !isFlipped.value;

  // Wenn die Karte jetzt auf der Vorderseite ist (isFlipped ist false), spiele den Sound.
  if (isFlipped.value === false) {
    playAudio();
  }
}


function handleMouseMove(event: MouseEvent) {
  if (!cardWrapper.value) return;
  const rect = cardWrapper.value.getBoundingClientRect();
  const mouseX = event.clientX - rect.left;
  const mouseY = event.clientY - rect.top;
  const percentX = mouseX / rect.width - 0.5;
  const percentY = mouseY / rect.height - 0.5;
  const maxTilt = 15;
  tiltX.value = -percentY * maxTilt;
  tiltY.value = percentX * maxTilt;
  scale.value = 1.05;
}

function handleMouseLeave() {
  tiltX.value = 0;
  tiltY.value = 0;
  scale.value = 1;
}

// COMPUTED STYLE
const cardStyle = computed(() => {
  const flipAngle = isFlipped.value ? 180 : 0;
  return {
    transform: `perspective(1000px) rotateX(${tiltX.value}deg) rotateY(${tiltY.value + flipAngle}deg) scale(${scale.value})`,
    transition: 'transform 0.6s ease-out'
  };
});
</script>

<template>
  <div 
    ref="cardWrapper" 
    class="scene w-full aspect-[5/7]" 
    @mousemove="handleMouseMove" 
    @mouseleave="handleMouseLeave"
    @click="flipCard"
  >
    <div class="card" :style="cardStyle">
      <div class="card__face card__face--front">
        <img :src="frontImageUrl" alt="Karten-Vorderseite" class="w-full h-full object-cover rounded-sm shadow-lg" />
        <img
          v-if="characterImageUrl"
          :src="characterImageUrl"
          alt="Pop-Out Charakter"
          class="character-pop-out" 
        />
      </div>
      <div class="card__face card__face--back">
        <img :src="backImageUrl" alt="Karten-Rückseite" class="w-full h-full object-cover rounded-sm shadow-lg" />
      </div>
    </div>
  </div>
</template>

<style scoped>
.scene {
  perspective: 1000px;
}

.card {
  width: 100%;
  height: 100%;
  position: relative;
  transform-style: preserve-3d;
  cursor: pointer;
}

/* KORREKTUR 3: Die .is-flipped Klasse wird nicht mehr gebraucht und kann entfernt werden. */
/*
.card.is-flipped {
  transform: rotateY(180deg);
}
*/

.card__face {
  position: absolute;
  width: 100%;
  backface-visibility: hidden;
  -webkit-backface-visibility: hidden;
}

.card__face--front {
  transform-style: preserve-3d;
}

.card__face--back {
  transform: rotateY(180deg);
}

.character-pop-out {
  position: absolute;
  bottom: 15%;
  left: 50%;
  width: 80%;
  transform: translateX(-50%) translateZ(0px) rotateY(0deg);
  transition: transform 0.8s cubic-bezier(0.23, 1, 0.32, 1), opacity 0.8s;
  opacity: 0.95;
  filter: drop-shadow(30px 50px 20px rgba(0, 0, 0, 1.0));
  pointer-events: none;
}

/* Der Pop-Out-Effekt wird jetzt über den card-Container gesteuert, nicht mehr über die is-flipped Klasse */
.card .character-pop-out {
  transform: translateX(-50%) translateY(-20%) translateZ(60px) rotateY(15deg);
  opacity: 1;
}

/* Wenn die Karte umgedreht ist, soll der Charakter wieder flach sein */
.card[style*="rotateY(180deg)"] .character-pop-out, /* Annäherung, funktioniert für den Flip */
.card:has(+ .is-flipped) .character-pop-out { /* Fallback */
    transform: translateX(-50%) translateZ(0px) rotateY(0deg);
    opacity: 0.95;
}

/* Da wir den Flip-Status nicht mehr per Klasse haben, ist eine saubere CSS-Lösung
   für das Ausblenden des Pop-Out-Effekts auf der Rückseite schwierig.
   Die JavaScript-Logik steuert aber die Drehung, was das Wichtigste ist.
   Der Charakter wird mit der Karte gedreht und ist somit nicht sichtbar. */
</style>



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
        <img :src="frontImageUrl" alt="Karten-Vorderseite" class="w-full h-full object-cover rounded-xl shadow-lg" />
        <img
          v-if="characterImageUrl"
          :src="characterImageUrl"
          alt="Pop-Out Charakter"
          class="character-pop-out" 
        />
      </div>
      <div class="card__face card__face--back">
        <img :src="backImageUrl" alt="Karten-Rückseite" class="w-full h-full object-cover rounded-xl shadow-lg" />
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
  height: 100%;
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



<!-- WICHTIG für Später

ZIEL.vue anpassen

Jetzt musst du nur noch in deiner Projects.vue den Aufruf anpassen, damit sie die neue Komponente verwendet.

Öffne /resources/js/pages/Projects.vue.

Ändere den import-Befehl am Anfang der Datei:

JavaScript

Imports
import InteractiveGameCard from '@/components/InteractiveGameCard.vue';


const gameCards = ref([
    {
        front: 'https://i.pinimg.com/474x/58/91/e8/5891e81a2390301da2c9a516d771f99d.jpg',
        back: 'https://images-wixmp-ed30a86b8c4ca887773594c2.wixmp.com/f/c741eead-0f8a-46df-b16d-18b58dbbe1ed/df36n3p-418a5ce3-258f-44ca-bd96-386409a64bdf.png?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ1cm46YXBwOjdlMGQxODg5ODIyNjQzNzNhNWYwZDQxNWVhMGQyNmUwIiwiaXNzIjoidXJuOmFwcDo3ZTBkMTg4OTgyMjY0MzczYTVmMGQ0MTVlYTBkMjZlMCIsIm9iaiI6W1t7InBhdGgiOiJcL2ZcL2M3NDFlZWFkLTBmOGEtNDZkZi1iMTZkLTE4YjU4ZGJiZTFlZFwvZGYzNm4zcC00MThhNWNlMy0yNThmLTQ0Y2EtYmQ5Ni0zODY0MDlhNjRiZGYucG5nIn1dXSwiYXVkIjpbInVybjpzZXJ2aWNlOmZpbGUuZG93bmxvYWQiXX0.XZfhJ9t5l1-7hPl2FMq5JyH_WOmhtZtw50VWe1IpdO4',
        character: '/images/cards/WhiteDragon.png',
        sound: '/sounds/animals/dragonroar.mp3'
    },
    {
        front: 'https://m.media-amazon.com/images/I/91nMuNBshYL.jpg', // Beispiel für eine zweite Karte
        back: 'https://images-wixmp-ed30a86b8c4ca887773594c2.wixmp.com/f/c741eead-0f8a-46df-b16d-18b58dbbe1ed/df36n3p-418a5ce3-258f-44ca-bd96-386409a64bdf.png?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ1cm46YXBwOjdlMGQxODg5ODIyNjQzNzNhNWYwZDQxNWVhMGQyNmUwIiwiaXNzIjoidXJuOmFwcDo3ZTBkMTg4OTgyMjY0MzczYTVmMGQ0MTVlYTBkMjZlMCIsIm9iaiI6W1t7InBhdGgiOiJcL2ZcL2M3NDFlZWFkLTBmOGEtNDZkZi1iMTZkLTE4YjU4ZGJiZTFlZFwvZGYzNm4zcC00MThhNWNlMy0yNThmLTQ0Y2EtYmQ5Ni0zODY0MDlhNjRiZGYucG5nIn1dXSwiYXVkIjpbInVybjpzZXJ2aWNlOmZpbGUuZG93bmxvYWQiXX0.XZfhJ9t5l1-7hPl2FMq5JyH_WOmhtZtw50VWe1IpdO4',
        character: '/images/cards/Blackmagican.png',
        sound: '/sounds/animals/summon.mp3'
    },
    {
        front: 'https://m.media-amazon.com/images/I/91nMuNBshYL.jpg', // Beispiel für eine zweite Karte
        back: 'https://images-wixmp-ed30a86b8c4ca887773594c2.wixmp.com/f/c741eead-0f8a-46df-b16d-18b58dbbe1ed/df36n3p-418a5ce3-258f-44ca-bd96-386409a64bdf.png?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ1cm46YXBwOjdlMGQxODg5ODIyNjQzNzNhNWYwZDQxNWVhMGQyNmUwIiwiaXNzIjoidXJuOmFwcDo3ZTBkMTg4OTgyMjY0MzczYTVmMGQ0MTVlYTBkMjZlMCIsIm9iaiI6W1t7InBhdGgiOiJcL2ZcL2M3NDFlZWFkLTBmOGEtNDZkZi1iMTZkLTE4YjU4ZGJiZTFlZFwvZGYzNm4zcC00MThhNWNlMy0yNThmLTQ0Y2EtYmQ5Ni0zODY0MDlhNjRiZGYucG5nIn1dXSwiYXVkIjpbInVybjpzZXJ2aWNlOmZpbGUuZG93bmxvYWQiXX0.XZfhJ9t5l1-7hPl2FMq5JyH_WOmhtZtw50VWe1IpdO4',
        character: '/images/cards/Blackmagican.png',
        sound: '/sounds/animals/summon.mp3'
    },
    {
        front: 'https://i.pinimg.com/474x/58/91/e8/5891e81a2390301da2c9a516d771f99d.jpg',
        back: 'https://images-wixmp-ed30a86b8c4ca887773594c2.wixmp.com/f/c741eead-0f8a-46df-b16d-18b58dbbe1ed/df36n3p-418a5ce3-258f-44ca-bd96-386409a64bdf.png?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ1cm46YXBwOjdlMGQxODg5ODIyNjQzNzNhNWYwZDQxNWVhMGQyNmUwIiwiaXNzIjoidXJuOmFwcDo3ZTBkMTg4OTgyMjY0MzczYTVmMGQ0MTVlYTBkMjZlMCIsIm9iaiI6W1t7InBhdGgiOiJcL2ZcL2M3NDFlZWFkLTBmOGEtNDZkZi1iMTZkLTE4YjU4ZGJiZTFlZFwvZGYzNm4zcC00MThhNWNlMy0yNThmLTQ0Y2EtYmQ5Ni0zODY0MDlhNjRiZGYucG5nIn1dXSwiYXVkIjpbInVybjpzZXJ2aWNlOmZpbGUuZG93bmxvYWQiXX0.XZfhJ9t5l1-7hPl2FMq5JyH_WOmhtZtw50VWe1IpdO4',
        character: '/images/cards/WhiteDragon.png',
        sound: '/sounds/animals/dragonroar.mp3'
    },
    // Füge hier so viele Karten hinzu, wie du möchtest
]);


BSPW:


    <div class="" id="Game Card">
        <section id="game-cards">
            <div class="text-center mb-12">
                 <h2 class="text-3xl font-bold text-white">Interaktive Karten</h2>
                 <p class="text-slate-400 max-w-2xl mx-auto mt-2">Klicke zum Drehen.</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                <div v-for="(card, index) in gameCards" :key="index">
                    <InteractiveCard 
                        :front-image-url="card.front"
                        :back-image-url="card.back"
                        :character-image-url="card.character"
                        :audio-url="card.sound"
                    />
                </div>
            </div>
        </section>
    </div>


Zeigt eine Karte an:
<InteractiveGameCard
    front-image-url="https://i.pinimg.com/474x/58/91/e8/5891e81a2390301da2c9a516d771f99d.jpg" 
    back-image-url="https://images-wixmp-ed30a86b8c4ca887773594c2.wixmp.com/f/c741eead-0f8a-46df-b16d-18b58dbbe1ed/df36n3p-418a5ce3-258f-44ca-bd96-386409a64bdf.png?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ1cm46YXBwOjdlMGQxODg5ODIyNjQzNzNhNWYwZDQxNWVhMGQyNmUwIiwiaXNzIjoidXJuOmFwcDo3ZTBkMTg4OTgyMjY0MzczYTVmMGQ0MTVlYTBkMjZlMCIsIm9iaiI6W1t7InBhdGgiOiJcL2ZcL2M3NDFlZWFkLTBmOGEtNDZkZi1iMTZkLTE4YjU4ZGJiZTFlZFwvZGYzNm4zcC00MThhNWNlMy0yNThmLTQ0Y2EtYmQ5Ni0zODY0MDlhNjRiZGYucG5nIn1dXSwiYXVkIjpbInVybjpzZXJ2aWNlOmZpbGUuZG93bmxvYWQiXX0.XZfhJ9t5l1-7hPl2FMq5JyH_WOmhtZtw50VWe1IpdO4" 
    character-image-url="https://images-wixmp-ed30a86b8c4ca887773594c2.wixmp.com/f/5a6af839-076e-448b-b7e8-47dcfb1f1af3/dez92nc-4b2f4def-4fed-4b69-af8c-aacc5103ccec.png?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ1cm46YXBwOjdlMGQxODg5ODIyNjQzNzNhNWYwZDQxNWVhMGQyNmUwIiwiaXNzIjoidXJuOmFwcDo3ZTBkMTg4OTgyMjY0MzczYTVmMGQ0MTVlYTBkMjZlMCIsIm9iaiI6W1t7InBhdGgiOiJcL2ZcLzVhNmFmODM5LTA3NmUtNDQ4Yi1iN2U4LTQ3ZGNmYjFmMWFmM1wvZGV6OTJuYy00YjJmNGRlZi00ZmVkLTRiNjktYWY4Yy1hYWNjNTEwM2NjZWMucG5nIn1dXSwiYXVkIjpbInVybjpzZXJ2aWNlOmZpbGUuZG93bmxvYWQiXX0.oSVtS4ODlksTU3jAL6PY8A-SCDnJhLMGlX9g1GWaj0g" > <template #back-content>
        <div class="flex flex-col items-center justify-center h-full gap-4">
            <h3 class="text-2xl font-bold text-white">Karten-Rückseite</h3>
            <p class="text-center">Hier kann beliebiger Text oder anderer Inhalt stehen.</p>
            <a href="#" class="mt-4 bg-cyan-500 hover:bg-cyan-600 text-white font-semibold py-2 px-4 rounded-lg">
                Ein Button
            </a>
        </div>
    </template>                
</InteractiveGameCard>




-->
<script setup lang="ts">
import { route } from 'ziggy-js';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import WebsiteLogoIcon from '@/components/WebsiteLogoIcon.vue';
import { BreadcrumbItem } from '@/types';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Startseite',
        href: '/',
    },
];

</script>


<template>

  <AppLayout :breadcrumbs="breadcrumbs">

                <div class="w-full grid place-items-center mx-auto bg-muted p-10 dark:border-r">        
                    <WebsiteLogoIcon/>
                </div>


        <div class="flex-1 container mx-auto">

                <div class="grid grid-cols-2 gap-3 grid-flow-dense lg:grid-cols-2 mt-8 bg-muted p-10 dark:border-r">
                  <h1 class="col-span-2 p-4 pr-6 bg-stone-100 border-1-8 border-transparent rounded-md shadow-md space-y-2 text-4xl font-bold bg-muted p-3">Willkommens H1 </h1>
                  <p class="col-span-3 p-4 pr-6 bg-stone-100 border-1-8 border-transparent rounded-md shadow-md space-y-2 text-3xl p-10">
                  Willkommens Nachricht
                  </p>
                </div>

                <div class="grid grid-cols-2 gap-3 grid-flow-dense lg:grid-cols-2 mt-8 bg-muted p-10 dark:border-r">
                  <h1 class="col-span-2 p-4 pr-6 bg-stone-100 border-1-8 border-transparent rounded-md shadow-md space-y-2 text-4xl font-bold bg-muted p-3">Subtext 1 H1 </h1>
                  <p class="col-span-3 p-4 pr-6 bg-stone-100 border-1-8 border-transparent rounded-md shadow-md space-y-2 text-3xl p-10">
                  Text Abschnitt
                  </p>
                </div>

                <div class="grid grid-cols-2 gap-3 grid-flow-dense lg:grid-cols-2 mt-8 bg-muted p-10 dark:border-r">
                  <h1 class="col-span-2 p-4 pr-6 bg-stone-100 border-1-8 border-transparent rounded-md shadow-md space-y-2 text-4xl font-bold bg-muted p-3">Subtext 2 H1 </h1>
                  <p class="col-span-3 p-4 pr-6 bg-stone-100 border-1-8 border-transparent rounded-md shadow-md space-y-2 text-3xl p-10">
                  Text Abschnitt
                  </p>
                </div>


                <div id="card_panel" class="flex-1 mt-8 p-10 bg-muted font-bold dark:border-r text-white text-3xl rounded">
                    <div class="grid grid-cols-2 grid-rows-5 gap-4 grid-flow-dense lg:grid-cols-3">
                      <div class="row-span-3 p-4 pr-6 bg-stone-100 border-1-8 border-transparent rounded-md shadow-md space-y-2">
                        <h2 class="text-lg font-bold text-black"> Sonstige Programmier Sprachen: </h2>
                        <div class="text-lg font-bold text-black break-normal text-wrap break-all mx-auto flex-1 mt-8 text-2xl font-bold bg-green-300 p-3 rounded-md shadow-md space-y-2 rounded">
                          <ul class="list-none">
                             <li> Python</li>
                             <li> C#</li>
                             <li> C+ +</li>
                             </ul>
                        </div>
                      </div>
                      <div class="row-span-3 p-4 pr-6 bg-stone-100 border-1-8 border-transparent rounded-md shadow-md space-y-2">
                        <h2 class="text-lg font-bold text-black"> Programmiersprachen Web: </h2>
                        <div class="text-lg font-bold text-black break-normal text-wrap break-all mx-auto flex-1 mt-8 text-2xl font-bold bg-red-300 p-3 rounded-md shadow-md space-y-2 rounded lg:flex ">
                          <ul class="list-none">
                             <li>HTML</li>
                             <li>JavaScript</li>
                             <li>PHP</li>
                             </ul>
                        </div>                      
                      </div>
                      <div class="row-span-3 p-4 pr-6 bg-stone-100 border-1-8 border-transparent rounded-md shadow-md space-y-2">
                        <h2 class="text-lg font-bold text-black"> Frameworks: </h2>
                        <div class="text-lg font-bold text-black break-normal text-wrap break-all mx-auto flex-1 mt-8 text-2xl font-bold bg-yellow-300 p-3 rounded-md shadow-md space-y-2 rounded lg:flex ">
                          <ul class="list-none">
                             <li>Drupal</li>
                             <li>Laravel</li>
                             <li>TYPO3</li>
                             </ul>
                        </div> 
                      </div>
                      <div class="col-span-3 row-span-3 p-4 pr-6 bg-stone-100 border-1-8 border-transparent rounded-md shadow-md space-y-2">
                        <h2 class="text-lg font-bold text-black"> Weitere Information: </h2>
                        <p class=" text-lg font-bold text-blackbreak-normal text-wrap max-h-full font-bold bg-blue-300 p-3 rounded-md shadow-md space-y-2">
                          Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
                          Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, 
                          when an unknown printer took a galley of type and scrambled it to make a type specimen book. 
                        </p>
                      </div>
                    </div>
                  </div> 
                </div>  

      <!--  <template #footer>
          <p class="text-sm">Kontaktiere uns bei Fragen: <a href="mailto:info@example.com" class="-500">info@example.com</a></p>
        </template> -->

  </AppLayout>

        <div id="site-footer" class="w-full mt-8 text-3xl font-bold bg-muted p-10 dark:border-r">
          <p class="text-sm">Kontaktiere uns bei Fragen: <a href="mailto:dennis-strauss@web.de" class="-500">dennis-strauss@web.de</a></p>
        </div>
</template>


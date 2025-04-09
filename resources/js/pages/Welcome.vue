<script setup>
import GuestLayout from '@/layouts/GuestLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import WebsiteLogoIcon from '@/components/WebsiteLogoIcon.vue';


</script>


<template>

  <GuestLayout :breadcrumbs="breadcrumbs">

    <template #footer>
      <p class="text-sm">Kontaktiere uns bei Fragen: <a href="mailto:info@example.com" class="text-blue-500">info@example.com</a></p>
    </template>


        <div class="flex-1 container mx-auto">
                <div class="container max-width: 1536px; overflow-hidden grid place-items-center mx-auto bg-muted p-10 dark:border-r">        
                    <WebsiteLogoIcon/>
                </div>

                <div>
                  <h1 class="mt-8 text-3xl font-bold bg-muted p-10 text-red dark:border-r lg:flex">Hello World</h1>
                </div>

                <p class="mt-8 text-3xl font-bold bg-muted p-10 text-blue dark:border-r lg:flex">
                  Schön, dass du da bist! Entdecke unsere neuesten Angebote und Funktionen.
                </p>

                <div class="mt-8 text-3xl font-bold bg-muted p-10 dark:border-r lg:flex">
                  <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    Mehr erfahren
                  </button>
                </div> 
            </div>
    
  
        <div class="mt-8 text-3xl font-bold bg-muted p-10 dark:border-r lg:flex">
          <p class="text-sm">Kontaktiere uns bei Fragen: <a href="mailto:info@example.com" class="text-blue-500">info@example.com</a></p>
        </div>

  </GuestLayout>

</template>


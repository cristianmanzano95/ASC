<template>
  <div id="q-app">
    <router-view />
  </div>
</template>
<script>

export default {
  name: 'App',
  el: 'otroid',
      methods: {
        onItemClick () {
          // console.log('Clicked on an Item')
        }
      },
      mounted() {
        this.$q.iconSet.arrow.dropdown = ""
}}

</script>

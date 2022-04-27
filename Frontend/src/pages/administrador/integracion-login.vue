<template></template>

<script>
export default {
  name: "integracion-login",
  data() {
    return {
      token: this.$route.params.token,
    };
  },
  created() {
    if (this.token) {
      this.$router.push("/solicitudes/pendientes");
      localStorage.setItem("token", this.token);
    }
  },
};
</script>

<style>
</style>
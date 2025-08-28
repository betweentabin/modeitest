<template>
  <router-link to="/login" class="button-2">
    <div class="text-62 valign-text-middle inter-bold-white-13px">ログイン</div>
  </router-link>
</template>

<script>
export default {
  name: "XButton2",
};
</script>

<style>
.button-2 {
  align-items: center;
  background-color: #1a1a1a;
  border-radius: 8px;
  box-shadow: 0px 1px 2px #0000000d;
  display: inline-flex;
  flex: 0 0 auto;
  flex-direction: column;
  height: 40px;
  justify-content: center;
  padding: 0px 24px 0px 20px;
  position: relative;
  text-decoration: none;
  cursor: pointer;
  transition: all 0.3s ease;
}

.button-2:hover {
  background-color: #da5761;
  transform: translateY(-2px);
  box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.15);
}

.text-62 {
  letter-spacing: 0;
  line-height: 19.5px;
  position: relative;
  white-space: nowrap;
  width: fit-content;
}
</style>

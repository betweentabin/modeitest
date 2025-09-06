<template>
  <div class="group-10-3">
    <div class="group-10-4">
      <div class="flex-row-1">
        <img
          class="vector-6-1"
          src="/img/vector-6.svg"
          alt="Vector 6"
        />
        <div class="text-8-1 valign-text-middle inter-bold-black-24px">アクセス</div>
      </div>
      <div class="place valign-text-middle inter-bold-black-48px">ACCESS</div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Group10",
};
</script>

<style>
.group-10-3 {
  height: auto;
  position: relative;
  width: auto;
}

.group-10-4 {
  align-items: flex-start;
  display: flex;
  flex-direction: column;
  gap: 20px;
  height: auto;
  width: auto;
}

.flex-row-1 {
  align-items: center;
  display: flex;
  gap: 23px;
  min-width: 209px;
}

.vector-6-1 {
  height: 1px;
  object-fit: cover;
  width: 60px;
}

.text-8-1 {
  height: 36px;
  letter-spacing: 0;
  line-height: 36px;
  min-width: 95px;
  white-space: nowrap;
  font-size: 24px !important;
}

.place {
  letter-spacing: 0;
  line-height: 72px;
  white-space: nowrap;
  font-size: 48px;
}

@media (max-width: 1150px) {
  .group-10-4 {
    gap: 15px !important;
  }

  .place {
    font-size: 44px !important;
    line-height: 52px !important;
  }

  .text-8-1 {
    font-size: 22px !important;
  }
}

@media (max-width: 900px) {
  .place {
    font-size: 40px !important;
    line-height: 48px !important;
  }

  .text-8-1 {
    font-size: 20px !important;
  }
}

@media (max-width: 768px) {
  .group-10-4 {
    gap: 15px !important;
  }

  .place {
    font-size: 36px !important;
    line-height: 44px !important;
  }

  .text-8-1 {
    font-size: 19px !important;
  }
}

@media (max-width: 480px) {
  .group-10-4 {
    gap: 10px !important;
  }

  .place {
    font-size: 32px !important;
    line-height: 40px !important;
  }

  .text-8-1 {
    font-size: 18px !important;
  }

  .vector-6-1 {
    width: 40px !important;
  }
}
</style>

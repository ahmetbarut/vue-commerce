<template>
  <div>
    <div
      class="
        flex flex-col
        justify-start
        items-start
        dark:bg-gray-800
        bg-gray-50
        px-4
        py-4
        md:py-6 md:p-6
        xl:p-8
        w-full
      "
    >
      <p
        class="
          text-lg
          md:text-xl
          dark:text-white
          font-semibold
          leading-6
          xl:leading-5
          text-gray-800
        "
      >
        Customer's Cart
      </p>
      <div
        v-for="cart in carts"
        :key="cart.id"
        class="
          mt-4
          md:mt-6
          flex flex-col
          md:flex-row
          justify-start
          items-start
          md:items-center md:space-x-6
          xl:space-x-8
          w-full
        "
      >
        <div
          class="
            border-b border-gray-200
            md:flex-row
            flex-col flex
            justify-between
            items-start
            w-full
            pb-8
            space-y-4
            md:space-y-0
          "
        >
          <div class="w-full flex flex-col justify-start items-start space-y-8">
            <h3
              class="
                text-xl
                dark:text-white
                xl:text-2xl
                font-semibold
                leading-6
                text-gray-800
              "
            >
              {{ cart.order_number }}
            </h3>
            <div class="flex justify-between space-x-8 items-start w-full">
              <p class="text-base dark:text-white xl:text-lg leading-6">
                $36.00 <span class="text-red-300 line-through"> $45.00</span>
              </p>
              <p
                class="
                  text-base
                  dark:text-white
                  xl:text-lg
                  leading-6
                  text-gray-800
                "
              >
                01
              </p>
              <p
                class="
                  text-base
                  dark:text-white
                  xl:text-lg
                  font-semibold
                  leading-6
                  text-gray-800
                "
              >
                {{ cart.amount }}
              </p>
            </div>
          </div>
        </div>
      </div>
      <div
        class="
          mt-6
          md:mt-0
          flex
          justify-start
          flex-col
          md:flex-row
          items-start
          md:items-center
          space-y-4
          md:space-x-6
          xl:space-x-8
          w-full
        "
      >
        <div
          class="
            flex
            justify-between
            items-start
            w-full
            flex-col
            md:flex-row
            space-y-4
            md:space-y-0
          "
        ></div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data() {
    return {
      carts: [],
    };
  },
  created() {
    var config = {
      "Content-Type": "application/json",
      Accept: "application/json",
      Authorization: "Bearer " + localStorage.getItem("user"),
    };
    axios({
      method: "POST",
      url: this.$api + "/api/orders",
      headers: config,
    }).then((response) => {
      this.carts = response.data;
    });
  },
};
</script>
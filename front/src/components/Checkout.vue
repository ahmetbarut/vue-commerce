<template>
  <div>
    <button
      class="
        bg-indigo-500
        font-semibold
        hover:bg-indigo-600
        py-3
        text-sm text-white
        uppercase
        w-full
      "
      @click="checkOutModal"
    >
      Checkout
    </button>
    <div
      v-show="modalStatus"
      id="defaultModal"
      aria-hidden="true"
      class="
        overflow-y-auto overflow-x-hidden
        fixed
        right-0
        left-0
        top-4
        z-50
        justify-center
        items-center
        h-modal
        md:h-full md:inset-0
        flex
        align-items-center
      "
    >
      <div class="relative px-4 w-full h-full md:h-auto max-w-3xl">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
          <div
            class="
              flex
              justify-between
              items-start
              p-5
              rounded-t
              border-b
              dark:border-gray-600
            "
          >
            <h3
              class="
                text-xl
                font-semibold
                text-gray-900
                lg:text-2xl
                dark:text-white
              "
            >
              Payment
            </h3>
            <button
              @click="checkOutModal"
              type="button"
              class="
                text-gray-400
                bg-transparent
                hover:bg-gray-200 hover:text-gray-900
                rounded-lg
                text-sm
                p-1.5
                ml-auto
                inline-flex
                items-center
                dark:hover:bg-gray-600 dark:hover:text-white
              "
              data-modal-toggle="defaultModal"
            >
              <svg
                class="w-5 h-5"
                fill="currentColor"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  fill-rule="evenodd"
                  d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                  clip-rule="evenodd"
                ></path>
              </svg>
            </button>
          </div>

          <div class="p-6 space-y-8">
            <!-- component -->
            <div class="leading-loose">
              <form class="max-w-xl m-4 p-10 bg-white rounded">
                <p class="text-gray-800 font-medium">Customer information</p>
                <div class="mb-6">
                  <label
                    for="username-success"
                    class="block mb-2 text-sm font-medium"
                    >Your name</label
                  >
                  <input
                    type="text"
                    id="username-success"
                    class="
                      border
                      text-sm
                      rounded-lg
                      focus:ring-green-500 focus:border-blue-500
                      block
                      w-full
                      p-2.5
                      dark:bg-green-100 dark:border-green-400
                    "
                    v-model="cardname"
                    placeholder="John Doe"
                  />
                </div>

                <div class="mb-6">
                  <label
                    for="username-success"
                    class="block mb-2 text-sm font-medium"
                    >Card Number</label
                  >
                  <input
                    type="text"
                    id="username-success"
                    class="
                      border
                      text-sm
                      rounded-lg
                      focus:ring-green-500 focus:border-blue-500
                      block
                      w-full
                      p-2.5
                      dark:bg-green-100 dark:border-green-400
                    "
                    placeholder="Card Number"
                    v-model="cardnumber"
                  />
                </div>

                <div class="flex flex-row justify-between">
                  <div class="mb-6">
                    <label
                      for="username-success"
                      class="block mb-2 text-sm font-medium"
                      >Card Expiry Date</label
                    >
                    <input
                      type="text"
                      id="username-success"
                      class="
                        border
                        text-sm
                        rounded-lg
                        focus:ring-green-500 focus:border-blue-500
                        block
                        w-full
                        p-2.5
                        dark:bg-green-100 dark:border-green-400
                      "
                      placeholder="Card Expiry Date"
                      v-model="cardexpiry"
                    />
                  </div>
                  <div class="mb-6">
                    <label
                      for="username-success"
                      class="block mb-2 text-sm font-medium"
                      >Card CVV</label
                    >
                    <input
                      type="text"
                      id="username-success"
                      class="
                        border
                        text-sm
                        rounded-lg
                        focus:ring-green-500 focus:border-blue-500
                        block
                        w-full
                        p-2.5
                        dark:bg-green-100 dark:border-green-400
                      "
                      placeholder="CVV"
                      v-model="cardcvv"
                    />
                  </div>
                </div>
                <div class="mt-4">
                  <button
                    @click="submit"
                    class="
                      px-4
                      py-1
                      text-white
                      font-light
                      tracking-wider
                      bg-gray-900
                      rounded
                    "
                    type="submit"
                  >
                    Checkout ${{ total }}
                  </button>
                </div>
              </form>
            </div>
          </div>

          <div
            class="
              flex
              items-center
              p-6
              space-x-2
              rounded-b
              border-t border-gray-200
              dark:border-gray-600
            "
          >
            <button
              @click="checkOutModal"
              data-modal-toggle="defaultModal"
              type="button"
              class="
                text-white
                bg-red-500
                focus:ring-4 focus:ring-gray-300
                rounded-lg
                border border-gray-200
                text-sm
                font-medium
                px-5
                py-2.5
                focus:z-10
                dark:text-gray-300 dark:border-gray-500
              "
            >
              Decline
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
export default {
  props: {
    total: {
      type: Number,
      default: 0,
    },
    carts: {
      type: Array,
      default: () => [],
    },
  },
  data() {
    return {
      modalStatus: false,
      cardname: "",
      cardnumber: "",
      cardexpiry: "",
      cardcvv: "",
    };
  },

  watch: {
    cardcvv: function (val) {
      if (val.length >= 3) {
        this.$nextTick(() => {
          this.cardcvv = val.substr(0, 3);
        });
      }
    },
    cardnumber: function (value) {
      if (value.length >= 16) {
        this.$nextTick(() => {
          this.cardnumber = value.substr(0, 16);
        });
      }
    },
    cardexpiry: function (value) {
      if (isNaN(value.substring(0, 2))) {
        this.$nextTick(() => {
          this.cardexpiry = "";
        });
      }

      if (value.substring(0, 2) > 12) {
        this.$nextTick(() => {
          this.cardexpiry = "";
        });
      }

      if (value.length == 2) {
        this.$nextTick(() => {
          this.cardexpiry = value + "/";
        });
      }

      if (value.length >= 6) {
        this.$nextTick(() => {
          this.cardexpiry = value.substring(0, 2) + "/" + value.substring(3, 5);
        });
      }
    },
    deep: true,
  },
  methods: {
    checkOutModal() {
      this.modalStatus = !this.modalStatus;
    },
    checkOut() {},
    resetCardExpiry() {
      this.cardexpiry = 0;
    },

    submit() {
      var config = {
        "Content-Type": "application/json",
        Accept: "application/json",
        Authorization: "Bearer " + localStorage.getItem("user"),
      };
      axios({
        method: "POST",
        url: this.$api + "/api/orders/checkout",
        headers: config,
        data: {
          cardname: this.cardname,
          cardnumber: this.cardnumber,
          cardexpiry: this.cardexpiry,
          cardcvv: this.cardcvv,
          carts: this.carts,
        },
      })
        .then(() => {
          // this.$emit("checkout", response.data);
          this.modalStatus = false;
          this.$parent.showSuccessMessage();
          this.$parent.resetCart();
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};
</script>
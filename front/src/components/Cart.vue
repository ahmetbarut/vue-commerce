<template>
  <div
    :class="{
      'translate-x-0 ease-out': cartOpen,
      'translate-x-full ease-in': !cartOpen,
    }"
    class="
      fixed
      right-0
      top-0
      max-w-xs
      w-full
      h-full
      px-6
      py-4
      transition
      duration-300
      transform
      overflow-y-auto
      bg-white
      border-l-2 border-gray-300
      translate-x-0
      ease-out
    "
  >
    <div class="flex items-center justify-between">
      <h3 class="text-2xl font-medium text-gray-700">Your cart</h3>
      <button @click="openCart" class="text-gray-600 focus:outline-none">
        <svg
          class="h-5 w-5"
          fill="none"
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path d="M6 18L18 6M6 6l12 12"></path>
        </svg>
      </button>
    </div>
    <hr class="my-3" />
    <h1>Total : {{ cartTotal }}</h1>

    <div class="flex justify-between mt-6" v-for="cart in carts" :key="cart.id">
      <div class="flex">
        <img
          class="h-20 w-20 object-cover rounded"
          :src="cart.image.path"
          alt=""
        />
        <div class="mx-3">
          <h3 class="text-sm text-gray-600">{{ cart.name }}</h3>
          <div class="flex items-center mt-2">
            <button
              class="text-gray-500 focus:outline-none focus:text-gray-600"
              @click="addToCart(cart)"
            >
              <svg
                class="h-5 w-5"
                fill="none"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"
                ></path>
              </svg>
            </button>
            <!-- <span class="text-gray-700 mx-2">2</span> -->
            <button
              @click="removeFromCart(cart)"
              class="text-gray-500 focus:outline-none focus:text-gray-600"
              :disabled="cart.quantity <= 1"
            >
              <svg
                class="h-5 w-5"
                fill="none"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </button>
            <span class="text-gray-600 ml-auto">
              <input
                type="text"
                v-model="cart.quantity"
                class="
                  appearance-none
                  block
                  w-full
                  bg-gray-200
                  text-gray-700
                  border border-gray-200
                  rounded
                  py-1
                  px-1
                  leading-tight
                  focus:outline-none focus:bg-white focus:border-gray-500
                "
              />
            </span>
          </div>
        </div>
      </div>
      <span class="text-gray-600"
        >${{ parseFloat(cart.price * cart.quantity).toFixed(2) }}</span
      >
    </div>
    <div class="mt-8" v-show="carts.length !== 0">
      <form class="flex items-center justify-center">
        <input
          class="
            block
            w-full
            rounded-md
            border-gray-300
            shadow-sm
            focus:border-blue-300
            focus:ring
            focus:ring-blue-200
            focus:ring-opacity-50
          "
          type="text"
          placeholder="Add promocode"
        />
        <button
          class="
            ml-3
            flex
            items-center
            px-3
            py-2
            bg-blue-600
            text-white text-sm
            uppercase
            font-medium
            rounded
            hover:bg-blue-500
            focus:outline-none focus:bg-blue-500
          "
        >
          <span>Apply</span>
        </button>
      </form>
    </div>
    <a
      v-show="carts.length !== 0"
      class="
        flex
        items-center
        justify-center
        mt-4
        px-3
        py-2
        bg-blue-600
        text-white text-sm
        uppercase
        font-medium
        rounded
        hover:bg-blue-500
        focus:outline-none focus:bg-blue-500
      "
    >
      <span class="cursor-pointer">
        <router-link :to="{ name: 'cart-total' }">Checkout</router-link>
      </span>
      <svg
        class="h-5 w-5 mx-2"
        fill="none"
        stroke-linecap="round"
        stroke-linejoin="round"
        stroke-width="2"
        viewBox="0 0 24 24"
        stroke="currentColor"
      >
        <path d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
      </svg>
    </a>
  </div>
  <!-- Cart -->
</template>

<script>
export default {
  props: {
    // cart: {
    //   type: Array,
    //   required: true
    // },
    cartOpen: {
      type: Boolean,
      required: true,
    },
  },

  data() {
    return {
      carts: [],
      quantity: 1,
    };
  },

  created() {
    if (localStorage.getItem("cart")) {
      this.carts = JSON.parse(localStorage.getItem("cart"));
    }
  },

  computed: {
    cartTotal() {
      let total = 0;
      this.carts.forEach((cart) => {
        total += parseFloat(cart.price) * parseFloat(cart.quantity);
      });
      return "$ " + parseFloat(total).toFixed(2);
    },
  },

  watch: {
    carts: {
      handler: function (cart) {
        if (cart !== undefined && cart.length > 0) {
          if (typeof cart[0].quantity !== "undefined") {
            cart[0].quantity =
              cart[0].quantity == 0 ? 1 : parseInt(cart[0].quantity).toFixed();
          }
          this.updateLocalStorage();
        }
      },
      deep: true,
    },
  },
  methods: {
    openCart() {
      this.$parent.cartToggle();
    },

    addToCart(product) {
      var check = this.carts.filter((item) => item.id == product.id);

      if (check.length === 0) {
        this.carts.push({
          id: product.id,
          name: product.name,
          price: product.price,
          image: product.image,
          user: product.user,
          category: product.category,
          quantity: 1,
        });
      } else {
        this.carts.filter(function (item) {
          if (item.id == product.id) {
            item.quantity = parseInt(item.quantity) + 1;
          }
        });
      }

      this.updateLocalStorage();
    },
    removeFromCart(product) {
      this.carts.filter((item) => {
        if (item.id === product.id && item.quantity > 1)
          item.quantity = parseInt(item.quantity).toFixed() - 1;
        else this.carts.splice(this.carts.indexOf(product), 1);
      });
      this.updateLocalStorage();
    },
    updateLocalStorage() {
      localStorage.setItem("cart", JSON.stringify(this.carts));
    },
  },
};
</script>

<template>
  <div class="container mx-auto mt-3">
    <Header :isOpen="cartOpen"></Header>
    <Cart ref="cardComponent" :cartOpen="cartOpen"></Cart>
    <div>
      <router-view></router-view>
    </div>
    <footer class="bg-gray-200">
      <div
        class="container mx-auto px-6 py-3 flex justify-between items-center"
      >
        <a href="#" class="text-xl font-bold text-gray-500 hover:text-gray-400"
          >Brand</a
        >
        <p class="py-2 text-gray-500 sm:py-0">All rights reserved</p>
      </div>
    </footer>
  </div>
</template>

<script>
import Header from "./components/Header.vue";
import Cart from "@/components/Cart.vue";

export default {
  name: "App",
  components: { Header, Cart },
  data() {
    return {
      products: [],
      loading: true,
      cartOpen: false,
      cart: [],
      cartCount: 0,
      hasLogin: false,
    };
  },

  mounted() {
    this.cartCount = this.$refs.cardComponent.carts.length;
  },

  created() {
    if (localStorage.getItem("user")) {
      this.hasLogin = true;
    }
  },

  methods: {
    addToCart(product) {
      this.$refs.cardComponent.addToCart(product);
    },
    removeFromCart(product) {
      this.cart.splice(this.cart.indexOf(product), 1);
    },
    toggleCart() {
      this.cartOpen = !this.cartOpen;
    },
    cartToggle() {
      this.cartOpen = !this.cartOpen;
    },

    login() {
      return this.hasLogin;
    },
  },
};
</script>

<style>
</style>

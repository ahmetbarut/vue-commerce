<template>
  <div class="container mx-auto mt-10">
    <div class="flex shadow-md my-10">
      <div class="w-3/4 bg-white px-10 py-10">
        <div class="flex justify-between border-b pb-8">
          <h1 class="font-semibold text-2xl">Shopping Cart</h1>
          <h2 class="font-semibold text-2xl">{{ cartItems }} Items</h2>
        </div>
        <div class="flex mt-10 mb-5">
          <h3 class="font-semibold text-gray-600 text-xs uppercase w-2/5">
            Product Details
          </h3>
          <h3
            class="
              font-semibold
              text-center text-gray-600 text-xs
              uppercase
              w-1/5
              text-center
            "
          >
            Quantity
          </h3>
          <h3
            class="
              font-semibold
              text-center text-gray-600 text-xs
              uppercase
              w-1/5
              text-center
            "
          >
            Price
          </h3>
          <h3
            class="
              font-semibold
              text-center text-gray-600 text-xs
              uppercase
              w-1/5
              text-center
            "
          >
            Total
          </h3>
        </div>
        <Alert v-show="orderShippingSuccess"></Alert>
        <div
          class="flex items-center hover:bg-gray-100 -mx-8 px-6 py-5"
          v-for="cart in carts"
          :key="cart.id"
        >
          <div class="flex w-2/5">
            <!-- product -->
            <div class="w-20">
              <img class="h-24" :src="cart.image.path" alt="" />
            </div>
            <div class="flex flex-col justify-between ml-4 flex-grow">
              <span class="font-bold text-sm">{{ cart.name }}</span>
              <span class="text-red-500 text-xs">Apple</span>
              <a
                href="#"
                class="font-semibold hover:text-red-500 text-gray-500 text-xs"
                >Remove</a
              >
            </div>
          </div>

          <div class="flex justify-center w-1/5">
            <svg
              @click="decrement(cart)"
              class="fill-current cursor-pointer text-gray-600 w-3"
              viewBox="0 0 448 512"
            >
              <path
                d="M416 208H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h384c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"
              />
            </svg>

            <input
              class="mx-2 border text-center w-20"
              v-model="cart.quantity"
              type="text"
            />

            <svg
              @click="increment(cart)"
              class="fill-current cursor-pointer text-gray-600 w-3"
              viewBox="0 0 448 512"
            >
              <path
                d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"
              />
            </svg>
          </div>
          <span class="text-center w-1/5 font-semibold text-sm"
            >${{ cart.price }}</span
          >
          <span class="text-center w-1/5 font-semibold text-sm"
            >${{ cart.price * cart.quantity }}</span
          >
        </div>

        <a href="#" class="flex font-semibold text-indigo-600 text-sm mt-10">
          <svg
            class="fill-current mr-2 text-indigo-600 w-4"
            viewBox="0 0 448 512"
          >
            <path
              d="M134.059 296H436c6.627 0 12-5.373 12-12v-56c0-6.627-5.373-12-12-12H134.059v-46.059c0-21.382-25.851-32.09-40.971-16.971L7.029 239.029c-9.373 9.373-9.373 24.569 0 33.941l86.059 86.059c15.119 15.119 40.971 4.411 40.971-16.971V296z"
            />
          </svg>
          Continue Shopping
        </a>
      </div>

      <div id="summary" class="w-1/4 px-8 py-10">
        <h1 class="font-semibold text-2xl border-b pb-8">Order Summary</h1>
        <div class="flex justify-between mt-10 mb-5">
          <span class="font-semibold text-sm uppercase"
            >Items {{ cartItems }}</span
          >
          <span class="font-semibold text-sm">{{ cartTotal }}$</span>
        </div>
        <div>
          <label class="font-medium inline-block mb-3 text-sm uppercase"
            >Shipping</label
          >
        </div>
        <div class="py-10">
          <label
            for="promo"
            class="font-semibold inline-block mb-3 text-sm uppercase"
            >Promo Code</label
          >
          <input
            type="text"
            id="promo"
            placeholder="Enter your code"
            class="p-2 text-sm w-full"
          />
        </div>
        <button
          class="
            bg-red-500
            hover:bg-red-600
            px-5
            py-2
            text-sm text-white
            uppercase
          "
        >
          Apply
        </button>
        <div class="border-t mt-8">
          <div
            class="flex font-semibold justify-between py-6 text-sm uppercase"
          >
            <span>Total cost</span>
            <span>${{ cartTotal }}</span>
          </div>
          <Checkout :total="cartTotal" :carts="carts"></Checkout>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import Checkout from "../components/Checkout.vue";
import Alert from "../components/Alert.vue";
export default {
  name: "cart-total",
  data() {
    return {
      carts: [],
      orderShippingSuccess: false,
    };
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
  created() {
    this.carts = JSON.parse(localStorage.getItem("cart")) || [];
  },
  computed: {
    cartTotal() {
      let total = 0;
      this.carts.forEach((cart) => {
        total += parseFloat(cart.price) * parseInt(cart.quantity);
      });
      return parseFloat(total).toFixed(2);
    },
    cartItems() {
      let total = 0;
      this.carts.forEach((cart) => {
        total += parseInt(cart.quantity);
      });
      return total;
    },
  },
  methods: {
    updateLocalStorage() {
      localStorage.setItem("cart", JSON.stringify(this.carts));
    },
    decrement(cart) {
      cart.quantity--;
      if (cart.quantity == 0) {
        this.carts.splice(this.carts.indexOf(cart), 1);
      }
    },
    increment(cart) {
      cart.quantity++;
    },
    showSuccessMessage() {
      this.orderShippingSuccess = true;
    },

    resetCart() {
      this.carts = [];
      this.updateLocalStorage();
    },
  },
  components: { Checkout, Alert },
};
</script>
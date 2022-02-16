<template>
  <div @mouseleave="focus = false">
    <input
      class="
        pl-10
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
      v-model="search"
      type="text"
      placeholder="Search"
      @focus="focus = true"
    />

    <div
      v-if="focus"
      class="w-full inline-flex flex-col justify-center text-gray-500"
    >
      <ul class="bg-white border border-gray-100 w-full mt-2">
        <li
          class="
            pl-8
            pr-2
            py-1
            border-gray-100
            relative
            cursor-pointer
            hover:bg-yellow-50 hover:text-gray-900
          "
          v-for="result in results"
          :key="result.id"
        >
          <router-link
            :to="{
              name: 'Product',
              params: {
                productId: result.id,
              },
            }"
          >
            <b>{{ result.category.name }}</b> {{ result.name }}
          </router-link>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import axios from "axios";
export default {
  components: {},
  data() {
    return {
      focus: false,
      search: "",
      results: [],
    };
  },
  watch: {
    search: function (search) {
      if (search.length > 2) {
        this.$router.push({ name: "search", query: { search: search } });
        axios
          .get(this.$api + "/api/products?search=" + search)
          .then((response) => {
            this.results = response.data.data;
          });
      }
    },
  },
  methods: {
  },
};
</script>
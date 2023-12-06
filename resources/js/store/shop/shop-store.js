const state = () => ({
  form: {
    name: null,
    email: null,
    user_id: null,
    phone_number: null,
    cart: null,
  },
  products: [],
  product: null,
});

const getters = {
  product: state => {
    return state.product;
  },
  products: state => {
    return state.products;
  },
};

const actions = {};

const mutations = {
  updateForm(state, form) {
    state.form = { ...state.form, ...form };
  },
  updateProduct(state, product) {
    state.product = product;
  },
  updateProducts(state, products) {
    state.products = products;
  },
  updateCart(state, cart) {
    state.form.cart = cart;
  },
};

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations,
};

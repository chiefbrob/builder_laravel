import { createStore } from 'vuex';
import { mount } from '@vue/test-utils';
// import { createLocalVue, mount } from '@vue/test-utils';
import RegisterUser from '@/components/auth/RegisterUser';
import _ from 'lodash';

// import NavRoot from '@/components/nav/NavRoot.vue';
// import Vuex from 'vuex';
// import VueRouter from 'vue-router';
// import store from '@/store';
import axios from 'axios';
import { shared } from '@/components/shared/index.js';

// const localVue = createLocalVue();

// localVue.component('nav-root', NavRoot);
// localVue.use(Vuex);
// localVue.use(VueRouter);

let MockAdapter = require('axios-mock-adapter');
let axiosMock = new MockAdapter(axios);

axios.post = jest.fn().mockImplementation(() => Promise.resolve());

window.axios = axios;

describe('RegisterUser.vue', () => {
  let wrapper;

  axiosMock.onPost('/register').reply(201, { data: { name: 'Peter Griffin' } });

  axiosMock.onGet('/api/v1/user').reply(201, { data: { name: 'Peter Griffin', id: 1 } });

  //   const router = new VueRouter();

  //   router.push = jest.fn();

  beforeEach(() => {
    const store = createStore({
      state() {
        return { count: 1 };
      },
    });

    wrapper = mount(RegisterUser, {
      global: {
        plugins: [store],
      },
    });

    // shared.forEach((item) => {
    //   wrapper.component(item.name, require('@/components/shared/' + item.path + '.vue').default);
    // });
  });

  afterEach(() => {
    wrapper = null;
    jest.resetModules();
    jest.clearAllMocks();
  });

  test('is a vue component', () => {
    expect(wrapper.vm).toBeTruthy();
  });

  test('it renders correctly', async () => {
    expect(wrapper.text().includes('Create new account')).toBe(true);
    const name = wrapper.find('input#name');
    expect(name.exists()).toBe(true);
    const email = wrapper.find('input#email');
    expect(email.exists()).toBe(true);
    const password = wrapper.find('input#password');
    expect(password.exists()).toBe(true);

    await name.setValue('Peter Griffin');
    await email.setValue('peter.griffin@email.com');
    await password.setValue('password');

    const submit = wrapper.find('#submit');
    expect(submit.exists()).toBe(true);

    await submit.trigger('click');

    await wrapper.vm.$nextTick();

    expect(axios.post).toHaveBeenCalledWith('/register', {
      name: 'Peter Griffin',
      email: 'peter.griffin@email.com',
      password: 'password',
    });
  });
});

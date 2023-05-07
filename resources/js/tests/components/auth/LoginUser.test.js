import { createLocalVue, mount } from '@vue/test-utils';
import LoginUser from '@/components/auth/LoginUser';
import NavRoot from '@/components/nav/NavRoot.vue';
import Vuex from 'vuex';
import VueRouter from 'vue-router';
import store from '@/store';

const localVue = createLocalVue();

localVue.component('nav-root', NavRoot);
localVue.use(Vuex);
localVue.use(VueRouter);

let MockAdapter = require('axios-mock-adapter');
let axiosMock = new MockAdapter(axios);

axios.post = jest.fn().mockImplementation(() => Promise.resolve());

describe('LoginUser.vue', () => {
  let wrapper;

  let user = {
    name: 'Peter Griffin',
    username: 'peter.griffin',
    email: 'peter.griffin@email.com',
  };

  axiosMock.onPost('/login').reply(201, { data: user });

  axiosMock.onGet('/api/v1/user').reply(201, { data: user });

  const router = new VueRouter();

  router.push = jest.fn();

  beforeEach(() => {
    wrapper = mount(LoginUser, {
      localVue,
      store,
      router,
    });
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
    expect(wrapper.text().includes('Login')).toBe(true);

    const username = wrapper.find('input#username');
    expect(username.exists()).toBe(true);
    const password = wrapper.find('input#password');
    expect(password.exists()).toBe(true);

    await username.setValue('peter.griffin');
    await password.setValue('password');

    const submit = wrapper.find('#loginbtn');
    expect(submit.exists()).toBe(true);

    await submit.trigger('click');

    await wrapper.vm.$nextTick();
    await wrapper.vm.$nextTick();

    expect(axios.post).toHaveBeenCalledWith('/login', {
      username: 'peter.griffin',
      password: 'password',
    });
  });
});

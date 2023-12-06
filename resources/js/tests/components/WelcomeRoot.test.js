import { createLocalVue, mount } from '@vue/test-utils';
import WelcomeRoot from '@/components/WelcomeRoot.vue';
import NavRoot from '@/components/nav/NavRoot.vue';
import Vuex from 'vuex';
import VueRouter from 'vue-router';
import store from '@/store';

const localVue = createLocalVue();

localVue.component('nav-root', NavRoot);
localVue.use(Vuex);
localVue.use(VueRouter);

describe('WelcomeRoot.vue', () => {
  let wrapper;

  beforeEach(() => {
    const router = new VueRouter();
    wrapper = mount(WelcomeRoot, {
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
    expect(wrapper.text().includes('Welcome to your app')).toBe(true);
  });
});

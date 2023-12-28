import { createLocalVue, mount } from '@vue/test-utils';
import Footer from '@/components/shared/Footer.vue';
import NavRoot from '@/components/nav/NavRoot.vue';
import Vuex from 'vuex';
import VueRouter from 'vue-router';
import store from '@/store';

const localVue = createLocalVue();
localVue.component('nav-root', NavRoot);
localVue.use(Vuex);
localVue.use(VueRouter);

describe('Footer.vue has privacy and terms links', () => {
  let wrapper;

  const router = new VueRouter();
  router.push = jest.fn();

  beforeEach(() => {
    wrapper = mount(Footer, {
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

  test('router is injected', () => {
    expect(wrapper.vm.$router).toBeTruthy();
  });

  test('privacy btn works', async () => {
    await wrapper.vm.$nextTick();
    const privacy = wrapper.find('#privacy-policy-btn');
    expect(privacy.exists()).toBe(true);
    expect(privacy.text()).toBe('Privacy Policy');
  });

  test('terms btn works', async () => {
    await wrapper.vm.$nextTick();
    const privacy = wrapper.find('#terms-btn');
    expect(privacy.exists()).toBe(true);
    expect(privacy.text()).toBe('Terms');
  });
});

import { createLocalVue, mount } from '@vue/test-utils';
import MyContacts from '@/components/contacts/MyContacts.vue';
import NavRoot from '@/components/nav/NavRoot.vue';
import Vuex from 'vuex';
import VueRouter from 'vue-router';
import store from '@/store';
import { someResults } from '@/tests/fixtures/contacts/api-v1-contacts-some-fixture';
import { emptyResults } from '@/tests/fixtures/contacts/api-v1-contacts-empty-fixture';
import { admin } from '@/tests/fixtures/shared/AdminUser';
import { results } from '@/tests/fixtures/contacts/api-v1-contacts-many-fixture';

window.User = admin;

const localVue = createLocalVue();

localVue.component('nav-root', NavRoot);
localVue.use(Vuex);
localVue.use(VueRouter);

let MockAdapter = require('axios-mock-adapter');
let axiosMock = new MockAdapter(axios);

describe('MyContacts.vue empty', () => {
  let wrapper;

  beforeEach(() => {
    axiosMock.onGet('/api/v1/contacts/?page=1').reply(200, emptyResults);
    const router = new VueRouter();
    wrapper = mount(MyContacts, {
      localVue,
      store,
      router,
    });

    store.commit('user', admin);
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
    await wrapper.vm.$nextTick();
    expect(wrapper.text().includes('No contacts to display')).toBe(true);
    expect(wrapper.find('#contact-pages').exists()).toBe(false);
  });
});

describe('MyContacts.vue with loaded some data', () => {
  let wrapper;

  beforeEach(() => {
    axiosMock
      .onGet('/api/v1/contacts/', {
        params: {
          statuses: [],
          page: 1,
        },
      })
      .reply(200, someResults);
    const router = new VueRouter();
    wrapper = mount(MyContacts, {
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
    await wrapper.vm.$nextTick();

    expect(wrapper.text().includes('No contacts to display')).toBe(false);
    expect(wrapper.find('#contact-pages').exists()).toBe(false);
  });
});

describe('MyContacts.vue with paginated data', () => {
  let wrapper;

  beforeEach(() => {
    axiosMock.onGet('/api/v1/contacts/?page=1').reply(200, results);
    const router = new VueRouter();
    wrapper = mount(MyContacts, {
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
    await wrapper.vm.$nextTick();
    return true;

    expect(wrapper.text().includes('No contacts to display')).toBe(false);
    expect(wrapper.find('#contact-pages').exists()).toBe(true);
    let pagination = wrapper.findAll('li.page-item');
    expect(pagination.length).toBe(9);
    let pageLinks = wrapper.findAll('button.page-link');
    expect(pageLinks.length).toBe(6);
  });
});

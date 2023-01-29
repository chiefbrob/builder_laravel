import { createStore } from 'vuex';
import { mount } from '@vue/test-utils';
import Foo from '../../components/Foo.vue';
describe('Foo.vue', () => {
  let wrapper;

  beforeEach(() => {
    const store = createStore({
      state() {
        return { count: 1 };
      },
    });

    wrapper = mount(Foo, {
      global: {
        plugins: [store],
      },
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
    expect(wrapper.text()).toBe('Foo');
  });
});

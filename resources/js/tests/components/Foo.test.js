import { createLocalVue, mount } from "@vue/test-utils";
import Foo from "../../components/Foo.vue";

const localVue = createLocalVue();

describe("Foo.vue", () => {
    let wrapper;

    beforeEach(() => {
        wrapper = mount(Foo, {
            localVue,
        });
    });

    afterEach(() => {
        wrapper = null;
        jest.resetModules();
        jest.clearAllMocks();
    });

    test("is a vue component", () => {
        expect(wrapper.vm).toBeTruthy();
    });

    test("it renders correctly", async () => {
        expect(wrapper.text()).toBe("Foo");
    });
});

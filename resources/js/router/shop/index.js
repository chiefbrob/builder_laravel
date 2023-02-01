export default [
  {
    path: '/shop',
    name: 'shop',
    component: () => import('../../components/shop/ShopRoot.vue'),
    meta: { requiresAuth: false },
  },
  {
    name: 'create-product',
    path: '/shop/products/create',
    component: () => import('../../components/shop/CreateProduct.vue'),
    meta: { requiresAdmin: true },
  },
  {
    name: 'view-product',
    path: '/shop/products/:slug',
    component: () => import('../../components/shop/ViewProduct.vue'),
    meta: { requiresAuth: false },
  },
  {
    name: 'edit-product',
    path: '/shop/products/:slug/edit',
    component: () => import('../../components/shop/EditProduct.vue'),
    meta: { requiresAdmin: true },
  },
];

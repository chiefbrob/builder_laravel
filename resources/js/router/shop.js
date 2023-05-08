import ShopRoot from '../components/shop/ShopRoot';
import CreateProduct from '../components/shop/CreateProduct';
import EditProduct from '../components/shop/EditProduct';
import ViewProduct from '../components/shop/ViewProduct';
import CartRoot from '../components/shop/cart/CartRoot';

export const shop = [
  {
    name: 'shop',
    path: '/shop',
    component: ShopRoot,
    meta: { requiresAuth: false },
  },
  {
    name: 'create-product',
    path: '/shop/products/create',
    component: CreateProduct,
    meta: { requiresAdmin: true },
  },
  {
    name: 'view-product',
    path: '/shop/products/:slug',
    component: ViewProduct,
    meta: { requiresAuth: false },
  },
  {
    name: 'edit-product',
    path: '/shop/products/:slug/edit',
    component: EditProduct,
    meta: { requiresAdmin: true },
  },
  {
    name: 'cart',
    path: '/cart',
    component: CartRoot,
    meta: { requiresAuth: false },
  },
];

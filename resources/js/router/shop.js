import ShopRoot from '../components/shop/ShopRoot';
import CreateProduct from '../components/shop/products/CreateProduct';
import EditProduct from '../components/shop/products/EditProduct';
import ViewProduct from '../components/shop/products/ViewProduct';
import CartRoot from '../components/shop/cart/CartRoot';
import ProductVariantSingle from '../components/shop/products/ProductVariantSingle';
import ProductVariantsRoot from '../components/shop/products/ProductVariantsRoot';
import CheckoutRoot from '../components/shop/checkout/CheckoutRoot';
import OrdersRoot from '../components/shop/orders/OrdersRoot';
import ViewOrderRoot from '../components/shop/orders/ViewOrderRoot';

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
    name: 'view-product-variants',
    path: '/shop/products/:slug/variants',
    component: ProductVariantsRoot,
    meta: { requiresAuth: false },
  },
  {
    name: 'view-product-variant',
    path: '/shop/products/:slug/variants/:variant_id',
    component: ProductVariantSingle,
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
  {
    name: 'checkout',
    path: '/checkout',
    component: CheckoutRoot,
    meta: { requiresAuth: false },
  },
  {
    name: 'orders',
    path: '/orders',
    component: OrdersRoot,
    meta: { requiresAuth: true },
  },
  {
    name: 'view-order',
    path: '/orders/:reference',
    component: ViewOrderRoot,
    meta: { requiresAuth: true },
  },
];

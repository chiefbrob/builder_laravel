export const someResults = {
  current_page: 1,
  data: [
    {
      id: 4,
      title: 'test blank',
      email: 'caroll@example.com',
      phone_number: '254704140232',
      user_id: 1,
      contents: null,
      default_image: null,
      url: null,
      status: 'PENDING',
      deleted_at: null,
      created_at: '2023-02-21T14:06:19.000000Z',
      updated_at: '2023-02-21T14:06:19.000000Z',
    },
    {
      id: 3,
      title: 'Something is broken',
      email: 'smith@example.com',
      phone_number: '254724101971',
      user_id: 1,
      contents: 'ABC when CDE',
      default_image: null,
      url: null,
      status: 'PENDING',
      deleted_at: null,
      created_at: '2023-02-21T14:05:31.000000Z',
      updated_at: '2023-02-21T14:05:31.000000Z',
    },
  ],
  first_page_url: 'https://laravel.test/api/v1/contacts?page=1',
  from: 1,
  last_page: 1,
  last_page_url: 'https://laravel.test/api/v1/contacts?page=1',
  links: [
    {
      url: null,
      label: '&laquo; Previous',
      active: false,
    },
    {
      url: 'https://laravel.test/api/v1/contacts?page=1',
      label: '1',
      active: true,
    },
    {
      url: null,
      label: 'Next &raquo;',
      active: false,
    },
  ],
  next_page_url: null,
  path: 'https://laravel.test/api/v1/contacts',
  per_page: 15,
  prev_page_url: null,
  to: 2,
  total: 2,
};
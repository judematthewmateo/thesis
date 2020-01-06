export default {
  items: [{
      name: 'Dashboard',
      url: '/dashboard',
      icon: 'icon-speedometer'
    },
    {
      name: 'References',
      url: '/references',
      icon: 'icon-book-open',
      children: [{
          name: 'All users',
          url: '/references/users',
          icon: 'icon-list'
        },

        {
          name: 'Departments',
          url: '/references/departments',
          icon: 'icon-list'
        },
      ]
    }
  ],
}
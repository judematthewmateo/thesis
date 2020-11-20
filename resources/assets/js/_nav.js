export default {
  items: [{
      name: 'Dashboard',
      url: '/dashboard',
      icon: 'icon-speedometer'
    },
    {
      name: 'Product',
      url: '/product',
      icon: 'icon-book-open',
      children:[
        {
          name: 'Product(s)',
          url: '/product/Products',
          icon: 'icon-list'
        },

      ]},
      
        {
        name: 'My Shop',
        url: '/Order',
        icon: 'fa fa-bars',
        children:[
          {
            name: 'Order(s)',
            url: '/order/Orders',
            icon: 'fa fa-handshake-o'
          },
          {
            name: 'Shipment(s)',
            url: '/inventory/purchasemains',
            icon: 'fa fa-shopping-cart'
          },
          {
            name: 'Cancellation',
            url: '/inventory/purchasemains',
            icon: 'fa fa-exclamation-circle'
          },
        ]},
        {
          name: 'Finance',
          // url: '/references',
          icon: 'fa fa-usd',
          children:[
            {
              name: 'Income',
              // url: '/references/categories',
              icon: 'fa fa-credit-card'
            },
    
          ]},
          {
            name: 'Shop',
            // url: '/references',
            icon: 'fa fa-tags',
            children:[
              {
                name: 'Category(s)',
                url: '/shop/category',
                icon: 'fa fa-code'
              },
              
              {
                name: 'Rating(s)',
                // url: '/references/categories',
                icon: 'fa fa-star-o'
              },

            ]},
            {
              name: 'Settings',
              // url: '/references',
              icon: 'fa fa-cogs',
              children:[
                {
                  name: 'Address',
                  // url: '/references/categories',
                  icon: 'fa fa-address-book-o'
                },
        
              ]},
  
  ],
}
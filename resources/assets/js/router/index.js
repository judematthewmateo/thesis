import Vue from "vue";
import Router from "vue-router";

// Containers
import Full from "@/containers/Full";

// Views
import Dashboard from "@/views/Dashboard";


// Views - Pages
import Page404 from "@/views/pages/Page404";
import Page500 from "@/views/pages/Page500";
import Login from "@/views/pages/Login";
import Logout from "@/views/pages/Logout";
import RegisterStaff from "@/views/pages/RegisterStaff";
import RegisterClient from "@/views/pages/RegisterClient";

import staff from "@/views/staff";


import departments from "@/views/references/Departments";
import staffs from "@/views/references/Staffs";
import clients from "@/views/references/Clients";


import store from "../store";
Vue.use(Router);

const router = new Router({
  mode: "hash", // Demo is living in GitHub.io, so required!
  linkActiveClass: "open active",
  scrollBehavior: () => ({
    y: 0
  }),
  routes: [{
      path: "/",
      redirect: "dashboard",
      name: "Home",
      component: Full,
      children: [{
          path: "dashboard",
          name: "Dashboard",
          component: Dashboard,
          meta: {
            requiresAuth: true
          }
        },
        {
          path: "references",
          name: "References",
          component: {
            render(c) {
              return c("router-view");
            }
          },

          children: [{
              path: "departments",
              name: "Departments",
              component: departments,

            },
            {
              path: "clients",
              name: "Clients",
              component: clients,

            },
            {
              path: "staffs",
              name: "Staffs",
              component: staffs,

            },
          ]
        },

      ]
    },




    {
      path: "/registerstaff",
      name: "Register Staff",
      component: RegisterStaff
    },
    {
      path: "/staff",
      name: "Staff",
      component: staff
    },
    {
      path: "/registerclient",
      name: "Register Client",
      component: RegisterClient
    },
    {
      path: "/login",
      name: "Login",
      component: Login
    },
    {
      path: "/logout",
      name: "Logout",
      component: Logout
    },
    {
      path: "*",
      name: "404",
      component: Page404
    },

  ]
});
export default router;
router.beforeEach((to, from, next) => {
  // check if the route requires authentication and user is not logged in
  if (
    to.matched.some(route => route.meta.requiresAuth) &&
    !store.state.isLoggedIn
  ) {
    // redirect to login page
    next({
      name: "Login"
    });
    return;
  }

  // if logged in redirect to dashboard
  if (to.path === "/login" && store.state.isLoggedIn) {
    next({
      name: from.name
    });
    return;
  }

  next();
});
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
import Register from "@/views/pages/Register";

import users from "@/views/references/Users";
import departments from "@/views/references/Departments";



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

              path: "users",
              name: "All users",
              component: users,
              meta: {
                requiresAuth: true
              }
            },
            {
              path: "departments",
              name: "Departments",
              component: departments,
              meta: {
                requiresAuth: true
              }
            },


          ]
        },
      ]
    },
    {
      path: "/register",
      name: "Register",
      component: Register
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
    }
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
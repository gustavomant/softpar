import { RouteRecordRaw } from "vue-router";

const routes: RouteRecordRaw[] = [
    {
        path: "/login",
        component: () => import("layouts/MainLayout.vue"),
        children: [{ path: "", component: () => import("pages/LoginPage.vue") }],
    },
    {
        path: "/register",
        component: () => import("layouts/MainLayout.vue"),
        children: [{ path: "", component: () => import("pages/RegisterPage.vue") }],
    },
    {
        path: "/",
        component: () => import("layouts/MainLayout.vue"),
        children: [
            {
                path: "",
                component: () => import("pages/TaskList.vue")
            },
            {
                path: ":taskId",
                component: () => import("pages/TaskDetails.vue"),
                props: true,
            },
        ],
        beforeEnter: (to, from, next) => {
            if (!localStorage.getItem('access_token')) {
                next('/login');
            } else {
                next();
            }
        }
    },
    {
        path: "/task-create",
        component: () => import("layouts/MainLayout.vue"),
        children: [{ path: "", component: () => import("pages/TaskCreate.vue") }],
        beforeEnter: (to, from, next) => {
            if (!localStorage.getItem('access_token')) {
                next('/login');
            } else {
                next();
            }
        }
    },
    {
        path: "/:catchAll(.*)*",
        component: () => import("pages/ErrorNotFound.vue"),
    },
];

export default routes;

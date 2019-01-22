import VueRouter from 'vue-router';
import ListTypesComponent from "./components/ListTypesComponent";
import TypeComponent from "./components/TypeComponent";
import AccessoryComponent from "./components/AccessoryComponent";
let routes = [
    {
        path: '/types',
        name: 'types',
        component: ListTypesComponent
    },
    {
        path: '/type',
        name: 'type',
        component: TypeComponent
    },
    {
        path: '/accessory',
        name: 'accessory',
        component: AccessoryComponent
    },
];

const router = new VueRouter({
    routes
});

export default router;
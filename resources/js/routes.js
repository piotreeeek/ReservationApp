import VueRouter from 'vue-router';
import ListTypesComponent from "./components/ListTypesComponent";
import TypeComponent from "./components/TypeComponent";
import AccessoryComponent from "./components/AccessoryComponent";
import ListAccessoriesComponent from "./components/ListAccessoriesComponent";
import ListWorkplacesComponent from "./components/ListWorkplacesComponent";
import WorkplaceComponent from "./components/WorkplaceComponent";
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
        path: '/accessories',
        name: 'accessories',
        component: ListAccessoriesComponent
    },
    {
        path: '/accessory',
        name: 'accessory',
        component: AccessoryComponent
    },
    {
        path: '/workplaces',
        name: 'workplaces',
        component: ListWorkplacesComponent
    },
    {
        path: '/workplace',
        name: 'workplace',
        component: WorkplaceComponent
    },
];

const router = new VueRouter({
    routes
});

export default router;
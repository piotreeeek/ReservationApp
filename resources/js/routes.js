import VueRouter from 'vue-router';
import ListTypesComponent from "./components/ListTypesComponent";
import TypeComponent from "./components/TypeComponent";
import AccessoryComponent from "./components/AccessoryComponent";
import ListAccessoriesComponent from "./components/ListAccessoriesComponent";
import ListWorkplacesComponent from "./components/ListWorkplacesComponent";
import WorkplaceComponent from "./components/WorkplaceComponent";
import ListUsersComponent from "./components/ListUsersComponent";
import UserComponent from "./components/UserComponent";
import ListReservationsComponent from "./components/ListReservationsComponent";
import ReservationComponent from "./components/ReservationComponent";
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
    {
        path: '/users',
        name: 'users',
        component: ListUsersComponent
    },
    {
        path: '/user',
        name: 'user',
        component: UserComponent
    },
    {
        path: '/reservations',
        name: 'reservations',
        component: ListReservationsComponent
    },
    {
        path: '/reservation',
        name: 'reservation',
        component: ReservationComponent
    },
];

const router = new VueRouter({
    routes,
    linkActiveClass: "active"
});

export default router;
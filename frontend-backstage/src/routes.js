/*!

=========================================================
* Light Bootstrap Dashboard React - v2.0.1
=========================================================

* Product Page: https://www.creative-tim.com/product/light-bootstrap-dashboard-react
* Copyright 2022 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://github.com/creativetimofficial/light-bootstrap-dashboard-react/blob/master/LICENSE.md)

* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

*/
import Ad from "views/Ad";
import Dashboard from "views/Dashboard.js";
import UserProfile from "views/UserProfile.js";
import OrderList from "views/OrderList.js";
import Typography from "views/Typography.js";
import Icons from "views/Icons.js";
import Maps from "views/Maps.js";
import Notifications from "views/Notifications.js";
import Upgrade from "views/Upgrade.js";
import Info from "views/Info";
import Qa from "views/Qa";
import Cart from "views/Cart";
import UserList from "views/UserList";
import Shop from "views/Shop";

const dashboardRoutes = [
  // {
  //   upgrade: true,
  //   path: "/upgrade",
  //   name: "Upgrade to PRO",
  //   icon: "nc-icon nc-alien-33",
  //   component: Upgrade,
  //   layout: "/admin",
  // },
  {
    path: "/account",
    name: "管理員帳號設定",
    icon: "nc-icon nc-settings-gear-64",
    component: UserProfile,
    layout: "/admin",
  },
  {
    path: "/order",
    name: "訂單管理",
    icon: "nc-icon nc-notes",
    component: OrderList,
    layout: "/admin",
  },
  {
    path: "/user",
    name: "會員資料管理",
    icon: "nc-icon nc-circle-09",
    component: UserList,
    layout: "/admin",
  },
  {
    path: "/ad",
    name: "廣告橫幅",
    icon: "nc-icon nc-grid-45",
    component: Ad,
    layout: "/admin",
  },
  {
    path: "/cart",
    name: "購機資訊",
    icon: "nc-icon nc-credit-card",
    component: Cart,
    layout: "/admin",
  },
  {
    path: "/shop",
    name: "線上商店",
    icon: "nc-icon nc-cart-simple",
    component: Shop,
    layout: "/admin",
  },
  {
    path: "/info",
    name: "購買須知",
    icon: "nc-icon nc-single-copy-04",
    component: Info,
    layout: "/admin",
  },
  {
    path: "/qa",
    name: "常見問題",
    icon: "nc-icon nc-chat-round",
    component: Qa,
    layout: "/admin",
  },
  {
    path: "/dashboard",
    name: "Dashboard",
    icon: "nc-icon nc-chart-pie-35",
    component: Dashboard,
    layout: "/admin",
  },
  {
    path: "/typography",
    name: "Typography",
    icon: "nc-icon nc-paper-2",
    component: Typography,
    layout: "/admin",
  },
  {
    path: "/icons",
    name: "Icons",
    icon: "nc-icon nc-atom",
    component: Icons,
    layout: "/admin",
  },
  {
    path: "/maps",
    name: "Maps",
    icon: "nc-icon nc-pin-3",
    component: Maps,
    layout: "/admin",
  },
  {
    path: "/notifications",
    name: "Notifications",
    icon: "nc-icon nc-bell-55",
    component: Notifications,
    layout: "/admin",
  },
];

export default dashboardRoutes;

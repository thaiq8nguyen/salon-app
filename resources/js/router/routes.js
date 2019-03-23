import Login from "Views/Login";
import Dashboard from "Views/Dashboard";
import AddTechnicianSales from "Views/AddTechnicianSales";
import UpdateTechnicianSales from "Views/UpdateTechnicianSales";
import Logout from "Views/Logout";
import Settings from "Views/Settings";

const routes = [
	{
		name: "Login",
		path: "/login",
		component: Login
	},
	{
		path: "/",
		redirect: "/login"
	},
	{
		name: "Dashboard",
		path: "/dashboard",
		component: Dashboard,
		meta: {
			title: "Dashboard"
		}
	},
	{
		name: "AddTechnicianSales",
		path: "/add-technician-sales",
		component: AddTechnicianSales,
		meta: {
			title: "Add Technician Sales"
		}
	},
	{
		name: "UpdateTechnicianSales",
		path: "/update-technician-sales",
		component: UpdateTechnicianSales,
		meta: {
			title: "Update Technician Sales"
		}
	},
	{
		name: "Settings",
		path: "/settings",
		component: Settings,
		meta: {
			title: "Settings",
			requiresAuth: true,
		}

	},
	{
		name: "Logout",
		path: "/logout",
		component: Logout

	}
];

export default routes;

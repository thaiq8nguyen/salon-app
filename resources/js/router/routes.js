import Login from "Views/Login";
import Registration from "Views/Registration";
import PendingRegistration from "Views/PendingRegistration";
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
		name: "Registration",
		path: "/registration",
		component: Registration
	},
	{
		name: "Pending Registration Approval",
		path: "/pending-registration",
		component: PendingRegistration,
	},
	{
		name: "Dashboard",
		path: "/dashboard",
		component: Dashboard,
		meta: {
			title: "Dashboard",
			requiresAuth: true,
		}
	},
	{
		name: "AddTechnicianSales",
		path: "/add-technician-sales",
		component: AddTechnicianSales,
		meta: {
			title: "Add Technician Sales",
			requiresAuth: true,
		}
	},
	{
		name: "UpdateTechnicianSales",
		path: "/update-technician-sales",
		component: UpdateTechnicianSales,
		meta: {
			title: "Update Technician Sales",
			requiresAuth: true,
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

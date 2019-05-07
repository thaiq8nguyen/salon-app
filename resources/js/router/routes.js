import Login from "Views/Login";
import Registration from "Views/Registration";
import PendingRegistration from "Views/PendingRegistration";
import Dashboard from "Views/Dashboard";
import AddTechnicianSales from "Views/AddTechnicianSales";
import UpdateTechnicianSales from "Views/UpdateTechnicianSales";
import Logout from "Views/Logout";
import Settings from "Views/Settings";
import Unauthorized from "Views/Unauthorized";

// Assistant Components

import AssistantDashboard from "Views/assistant/AssistantDashboard";

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
		meta: {
			requiresAuth: true,
		}
	},
	{
		name: "Dashboard",
		path: "/dashboard",
		component: Dashboard,
		meta: {
			title: "Dashboard",
			requiresAuth: true,
			isAdmin: true,

		}
	},
	{
		name: "AddTechnicianSales",
		path: "/add-technician-sales",
		component: AddTechnicianSales,
		meta: {
			title: "Add Technician Sales",
			requiresAuth: true,
			isAdmin: true,
		}
	},
	{
		name: "UpdateTechnicianSales",
		path: "/update-technician-sales",
		component: UpdateTechnicianSales,
		meta: {
			title: "Update Technician Sales",
			requiresAuth: true,
			isAdmin: true,
		}
	},
	{
		name: "Settings",
		path: "/settings",
		component: Settings,
		meta: {
			title: "Settings",
			requiresAuth: true,
			isAdmin: true,
		}

	},
	{
		name: "Logout",
		path: "/logout",
		component: Logout

	},
	{
		name: "Unauthorized",
		path: "/unauthorized",
		component: Unauthorized,
		meta: {
			requiresAuth: true
		}
	},
	{
		name: "AssistantDashboard",
		path: "/assistant/dashboard",
		component: AssistantDashboard,
		meta: {
			requiresAuth: true,
			isAssistant: true,
		}
	}
];

export default routes;

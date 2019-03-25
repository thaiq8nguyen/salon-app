import TechnicianServices from "Services/technician-services";

export default {

	INITIALIZE_STATE (state) {

	},

	SET_TECHNICIANS (state, value) {

		state.technicians = value;

	},
	ADD_TECHNICIAN_TO_TECHNICIANS (state, technician) {

		state.technicians.push(technician);

	},

};

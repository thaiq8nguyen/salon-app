import TechnicianServices from "Services/technician-services";

export default {

	getTechnicians () {

		return new Promise((resolve, reject) => {

			return TechnicianServices.getTechnicians("/technicians")
				.then((response) => {

					resolve(response.data.technicians);

				})
				.catch((errors) => {

					reject(errors);

				});

		});

	},
	addTechnician ({ commit }, technician) {

		return new Promise((resolve, reject) => {

			return TechnicianServices.addTechnician(technician)
				.then(response => {

					commit("ADD_TECHNICIAN_TO_TECHNICIANS", response.data.technician)
					resolve(response.data.technician);

				})
				.catch((errors) => {

					reject(errors);

				});

		});
	},




};

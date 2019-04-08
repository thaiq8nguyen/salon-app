// Users

import UserServices from "Services/user-services";
export default {

	getUnApprovedUsers ({ commit }) {

		return UserServices.getUnApprovedUsers()
			.then(response => {

				commit("SET_UNAPPROVED_USERS", response.data.users);

			})
			.catch(errors => {

				console.log(errors);

			});

	},
	approveUser ({ commit }, userID) {

		return UserServices.approveUser(userID)
			.then((response) => {

				console.log(response.data.users);

			})
			.catch(errors => {

				console.log(errors);

			});

	}
};

import AppSettingServices from "Services/app-setting-services";

export default {

	getSettings () {

		return new Promise((resolve, reject) => {

			return AppSettingServices.getSettings()
				.then(response => {

					resolve(response.data.settings);

				})
				.catch(errors => {

					reject(errors);

				});

		});

	},
};

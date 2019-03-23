const load = (state) => {

	try {

		const serializedState = localStorage.getItem(state);
		if (serializedState === null) {

			return undefined;

		}
		return JSON.parse(serializedState);

	} catch (errors) {

		return undefined;

	}

};

const save = (module, state) => {

	try {

		const serializedState = JSON.stringify(state);
		localStorage.setItem(module, serializedState);

	} catch (errors) {

	}

};

const remove = (module) => {

	try {

		localStorage.removeItem(module);

	} catch (errors) {

	}

};

export default {
	load, save, remove
};

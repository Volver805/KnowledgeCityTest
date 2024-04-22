const baseURL = 'http://api.cc.localhost'

const getCourses = category => {
    fetch(`${baseURL}/courses${category ? `?category_id=${category}` : ''}`, {
        method: 'GET',
        mode:'cors',
        headers: {
            "Content-Type": "application/json",
        }
    })
        .then(res => res.json())
        .then(courses => {
            console.log(courses);
        })
        .catch(err => {
            console.error('Server Error', err);
        });
}

const getCategories = () => {
    fetch(`${baseURL}/categories`, {
        method: 'GET',
        mode:'cors',
        headers: {
            "Content-Type": "application/json",
        }
    })
        .then(res => res.json())
        .then(courses => {
            console.log(courses);
        })
        .catch(err => {
            console.error('Server Error', err);
        });
}

const findCourseById = id => {
    fetch(`${baseURL}/courses/${id}`, {
        method: 'GET',
        mode:'cors',
        headers: {
            "Content-Type": "application/json",
        }
    })
        .then(res => res.json())
        .then(courses => {
            console.log(courses);
        })
        .catch(err => {
            console.error('Server Error', err);
        });
}

const findCategoryById = id => {
    fetch(`${baseURL}/categories/${id}`, {
        method: 'GET',
        mode:'cors',
        headers: {
            "Content-Type": "application/json",
        }
    })
        .then(res => res.json())
        .then(courses => {
            console.log(courses);
        })
        .catch(err => {
            console.error('Server Error', err);
        });
}

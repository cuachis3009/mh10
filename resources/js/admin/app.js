window._ = require('lodash');

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.swal = require('jquery-validation');

import swal from 'sweetalert2';
window.Swal = swal;
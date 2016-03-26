/**
 * Mesour Modal Component - mesour.modal.js
 * @author Matous Nemec (http://mesour.com)
 */
var mesour = !mesour ? {} : mesour;
mesour.modal = !mesour.modal ? {} : mesour.modal;

(function ($) {

    var Modal = function (options) {

        var _this = this,
            modals = {};

        function getModal(modal) {
            if (typeof modal === 'string') {
                if (!modals[modal]) {
                    throw new Error('Modal "' + modal + '" not exist.');
                }
                return modals[modal];
            }
            return modal;
        };

        this.create = function ($modals) {
            $modals.each(function () {
                var $modal = $(this),
                    show = $modal.attr('data-mesour-show'),
                    name = $modal.attr('data-mesour-modal');

                $modal.modal();
                modals[name] = $modal;
                if (show === 'true') {
                    _this.show($modal);
                }
            });
        };

        this.getModal = function (modal) {
            return getModal(modal);
        };

        this.getBody = function (modal) {
            return getModal(modal).find('[mesour-modal-body]');
        };

        this.onHide = function (modal, callback) {
            modal = getModal(modal);
            modal.off('hide.bs.modal.mesour-editable');
            return getModal(modal).on('hide.bs.modal.mesour-editable', callback);
        };

        this.show = function (modal, callback) {
            modal = getModal(modal);
            var modalBody = modal.find('[mesour-modal-body]'),
                ajaxLoading = modalBody.attr('data-ajax-loading'),
                isCached = modalBody.attr('data-is-cached') === 'true' ? true : false;

            if (ajaxLoading === 'false') {
                if (typeof callback === 'function') {
                    callback(modal);
                }
                modal.modal('show');
            } else {
                var isCacheSaved = modalBody.attr('data-cache-saved');
                if (isCached && isCacheSaved) {
                    modal.modal('show');
                } else {
                    var link = mesour.core.createLink(ajaxLoading, 'getContent');
                    $.get(link).complete(function (response) {
                        modalBody.empty().append(response.responseText);
                        modalBody.attr('data-cache-saved', 'true');
                        if (typeof callback === 'function') {
                            callback(modal, response);
                        }
                        modal.modal('show');
                    });
                }
            }
        };

        this.hide = function (modal) {
            modal = getModal(modal);

            modal.modal('hide');

            var modalBody = modal.find('[mesour-modal-body]'),
                ajaxLoading = modalBody.attr('data-ajax-loading'),
                isCached = modalBody.attr('data-is-cached') === 'true' ? true : false;

            if (!isCached && ajaxLoading !== 'false') {
                modalBody.empty();
            }
            return modal;
        };

        this.toggle = function (modal) {
            return getModal(modal).modal('toggle');
        };

        this.handleUpdate = function (modal) {
            return getModal(modal).modal('handleUpdate');
        };

        mesour.on.ready('mesour-modal', function () {
            _this.create($('[data-mesour-modal]'));
        });
    };

    mesour.core.createWidget('modal', new Modal());
})(jQuery);
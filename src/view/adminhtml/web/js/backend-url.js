define(function () {
  'use strict';

  /**
   * Component for receiving backend URL links with dynamic parameters
   * @public
   *
   * @var {Object} options
   * @return {Function}
   */
  return function (options) {
    options.urls = options.urls ?? {};

    return {

      /**
       * Get registered backend custom URL by alias
       * @public
       *
       * @param {String} alias
       * @param {{String:String}} params
       * @param {Boolean} asSearchParams
       *
       * @return {String}
       */
      get: function (alias, params = {}, asSearchParams = false) {
        /** @var {URL} url */
        const url = new URL(options.urls[alias] ?? null);

        Object.entries(params).forEach(([name, value]) =>
          !asSearchParams ? url.pathname += `${name}/${value}/` : url.searchParams.set(name, value));

        return url.href;
      }
    };
  };
});

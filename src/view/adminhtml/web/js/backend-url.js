define(function () {
  'use strict';

  /**
   * Component for receiving backend URL links with dynamic parameters
   */
  return function (options) {
    options.urls = options.urls ?? {};

    return {

      /**
       * Get registered backend custom URL by code
       * @public
       *
       * @param {String} code
       * @param {{String:String|Number}} params
       * @param {Boolean} asSearchParams
       *
       * @return {String}
       */
      get: function (code, params = {}, asSearchParams = false) {
        /** @var {URL} url */
        const url = new URL(options.urls[code] ?? null);

        Object.entries(params).forEach(([name, value]) =>
          !asSearchParams ? url.pathname += `${name}/${value}/` : url.searchParams.set(name, value));

        return url.href;
      }
    };
  };
});

/*!
 * Piwik - free/libre analytics platform
 *
 * SimplePageBuilder plugin screenshot tests.
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

describe("SimplePageBuilder", function () {
    this.timeout(0);

    it("should load correctly", function (done) {
        expect.screenshot('loaded').to.be.captureSelector('.simple-page', function (page) {
            page.load("?module=SimplePageBuilder&action=&idSite=1&period=day&date=2015-07-27");
        }, done);
    });
});
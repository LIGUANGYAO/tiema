// Provide a default path to dwr.engine
if (dwr == null) var dwr = {};
if (dwr.engine == null) dwr.engine = {};
if (DWREngine == null) var DWREngine = dwr.engine;

if (CheckMobileSection == null) var CheckMobileSection = {};
CheckMobileSection._path = '/dwr';
CheckMobileSection.checkUsrType = function(p0, callback) {
  dwr.engine._execute(CheckMobileSection._path, 'CheckMobileSection', 'checkUsrType', p0, callback);
}


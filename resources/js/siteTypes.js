export const SITE_TYPES = [
  { value: 'city', messageId: 'siteTypeCity', color: '#8b4a30', marker: '★', shape: 'star', size: 17 },
  { value: 'sanctuary', messageId: 'siteTypeSanctuary', color: '#047857', marker: '●', shape: 'circle', size: 17 },
  { value: 'fortress', messageId: 'siteTypeFortress', color: '#1d4ed8', marker: '■', shape: 'square', size: 17 },
  { value: 'monument', messageId: 'siteTypeMonument', color: '#b45309', marker: '▲', shape: 'triangle', size: 20 },
  { value: 'religious-complex', messageId: 'siteTypeReligiousComplex', color: '#a21caf', marker: '◆', shape: 'diamond', size: 19 },
];

export const SITE_TYPE_MESSAGE_IDS = Object.fromEntries(
  SITE_TYPES.map(siteType => [siteType.value, siteType.messageId])
);

export const SITE_TYPE_MARKER_COLOR = [
  'match',
  ['get', 'site_type'],
  ...SITE_TYPES.flatMap(siteType => [siteType.value, siteType.color]),
  '#74685a',
];

export const SITE_TYPE_MARKER_ICON = [
  'match',
  ['get', 'site_type'],
  ...SITE_TYPES.flatMap(siteType => [siteType.value, siteType.marker]),
  '★',
];

export const SITE_TYPE_MARKER_SIZE = [
  'match',
  ['get', 'site_type'],
  ...SITE_TYPES.flatMap(siteType => [siteType.value, siteType.size]),
  18,
];

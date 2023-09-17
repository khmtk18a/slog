import { formatDistanceToNow } from "date-fns";

const agoTime = (value) => {
  return formatDistanceToNow(new Date(value), { addSuffix: true });
};

export { agoTime };

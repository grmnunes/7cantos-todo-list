export default function ({ children }) {
  return (
    <div className="bg-blue-200 rounded-xl w-full m-20 h-3/4 flex justify-center overflow-y-scroll">
      {children}
    </div>
  );
}

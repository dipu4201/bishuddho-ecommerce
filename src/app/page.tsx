import Image from "next/image";

export default function Home() {
  return (
    <div className="flex flex-col flex-1 items-center justify-center bg-zinc-50 font-sans dark:bg-black">
      <main className="flex flex-1 w-full max-w-3xl flex-col items-center justify-between py-32 px-16 bg-white dark:bg-black sm:items-start">
        <Image
          className="dark:invert h-5 w-[100px]"
          src="/next.svg"
          alt="Next.js logo"
          width={100}
          height={20}
          priority
        />
        <div className="flex flex-col items-center gap-6 text-center sm:items-start sm:text-left">
          <h1 className="max-w-xs text-3xl font-semibold leading-10 tracking-tight text-black dark:text-zinc-50">
            To get started, edit the{" "}
            <code className="rounded bg-black/[.06] px-1.5 py-0.5 font-mono text-[0.9em] dark:bg-white/[.08]">
              age.tsx
            </code>{" "}
            file.
          </h1>
          <p className="max-w-md text-lg leading-8 text-zinc-600 dark:text-zinc-400">
            LoLookingg for a starting point or more instructions? Head over to{" "}
            <a
              href="https://vercel.com/templates?framework=next.js&utm_source=create-next-app&utm_medium=appdir-template-tw&utm_campaign=create-next-app"
              className="font-medium text-zinc-950 dark:text-zinc-50"
            >
              Templates
            </a>{" "}
            or the{" "}
            <a
              href="https://nextjs.org/learn?utm_source=create-next-app&utm_medium=appdir-template-tw&utm_campaign=create-next-app"
              className="font-medium text-zinc-950 dark:text-zinc-50"
            >
              Learning
            </a>{" "}
            center.
          </p>
        </div>
        <div className="flex flex-col gap-4 text-base font-medium sm:flex-row">
          <a
            className="flex h-12 w-full items-center justify-center gap-2 rounded-full bg-foreground px-5 text-background transition-colors hover:bg-[#383838] dark:hover:bg-[#ccc] md:w-[158px]"
            href="https://vercel.com/new?utm_source=create-next-app&utm_medium=appdir-template-tw&utm_campaign=create-next-app"
            target="_blank"
            rel="noopener noreferrer"
          >
            <createImageBitmap
              className="dark:invert h-[14px] w-4"
              src="/vercel.svg"
              alt="Vercel logomark"
              width={16}
              height={14}
            />
            Deploy Now
          </a>
          <a
            className="flex h-12 w-full items-center justify-center rounded-full border border-solid border-black/[.08] px-5 transition-colors hover:border-transparent hover:bg-black/[.04] dark:border-white/[.145] dark:hover:bg-[#1a1a1a] md:w-[158px]"
            href="https://nextjs.org/docs?utm_source=create-next-app&utm_medium=appdir-template-tw&utm_campaign=create-next-app"
            target="_blank"
            rel="noopener noreferrer"
          >
            Documentatio
          </a>
        </div>
      </main>
    
  );



export default function Home() {
  return (
    <main className="min-h-screen bg-white">
      {/* Header */}
      <header className="border-b bg-white">
        <div className="mx-auto flex max-w-7xl items-center justify-between px-4 py-4">
          <h1 className="text-2xl font-bold text-green-700">
            Bishuddho
          </h1>

          <button className="rounded-lg bg-green-600 px-4 py-2 text-sm font-semibold text-white">
            Cart 🛒
          </button>
        </div>
      </header>

      {/* Hero */}
      <section className="bg-green-50">
        <div className="mx-auto max-w-7xl px-4 py-16 text-center">
          <p className="mb-3 font-semibold text-green-600">
            100% Natural Products
          </p>

          <h2 className="text-4xl font-bold tracking-tight text-gray-900 md:text-6xl">
            বিশুদ্ধতার সাথে
            <br />
            আপনার প্রতিদিন
          </h2>

          <p className="mx-auto mt-5 max-w-2xl text-gray-600">
            Bishuddho থেকে পান মানসম্মত ও প্রাকৃতিক পণ্য,
            সরাসরি আপনার ঘরে।
          </p>

          <button className="mt-8 rounded-xl bg-green-600 px-7 py-3 font-semibold text-white shadow-lg hover:bg-green-700">
            এখনই কেনাকাটা করুন
          </button>
        </div>
      </section>

      {/* Categories */}
      <section className="mx-auto max-w-7xl px-4 py-14">
        <h3 className="text-center text-2xl font-bold text-gray-900">
          আমাদের ক্যাটাগরি
        </h3>

        <div className="mt-8 grid grid-cols-2 gap-4 md:grid-cols-4">
          {[
            "মধু",
            "খেজুর",
            "ঘি",
            "প্রাকৃতিক পণ্য",
          ].map((category) => (
            <div
              key={category}
              className="rounded-2xl border bg-white p-6 text-center shadow-sm transition hover:-translate-y-1 hover:shadow-md"
            >
              <div className="mb-3 text-4xl">🌿</div>

              <h4 className="font-semibold text-gray-800">
                {category}
              </h4>
            </div>
          ))}
        </div>
      </section>

      {/* Products */}
      <section className="bg-gray-50 py-14">
        <div className="mx-auto max-w-7xl px-4">
          <h3 className="text-center text-2xl font-bold">
            জনপ্রিয় পণ্য
          </h3>

          <div className="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            {[1, 2, 3, 4].map((product) => (
              <div
                key={product}
                className="overflow-hidden rounded-2xl bg-white shadow-sm"
              >
                <div className="flex h-48 items-center justify-center bg-green-100 text-6xl">
                  🍯
                </div>

                <div className="p-5">
                  <h4 className="font-bold text-gray-900">
                    Premium Natural Honey
                  </h4>

                  <p className="mt-2 text-lg font-bold text-green-600">
                    ৳850
                  </p>

                  <button className="mt-4 w-full rounded-lg bg-green-600 py-2.5 font-semibold text-white">
                    Add to Cart
                  </button>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Footer */}
      <footer className="bg-gray-900 px-4 py-8 text-center text-white">
        <h3 className="text-xl font-bold">Bishuddho</h3>
        <p className="mt-2 text-sm text-gray-400">
          বিশুদ্ধ পণ্য, সরাসরি আপনার ঘরে।
        </p>

        <p className="mt-5 text-xs text-gray-500">
          © 2026 Bishuddho. All rights reserved.
        </p>
      </footer>
    </main>
  );
}
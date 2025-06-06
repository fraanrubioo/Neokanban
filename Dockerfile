
FROM node:20 as builder

WORKDIR /app

COPY backend/package.json ./
RUN npm install

COPY . .

RUN npm run build

FROM node:20

WORKDIR /app

COPY --from=builder /app/dist ./dist
COPY --from=builder /app/package.json ./

RUN npm install --omit=dev

EXPOSE 3000

CMD ["node", "dist/index.js"]